<?php

namespace App\Controller\Admin;

use App\Entity\User;

use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeCrudActionEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Exception\ForbiddenActionException;
use EasyCorp\Bundle\EasyAdminBundle\Exception\InsufficientEntityPermissionException;
use EasyCorp\Bundle\EasyAdminBundle\Factory\EntityFactory;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Security\Permission;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class UserCrudController extends AbstractCrudController
{
    public function __construct(private SessionInterface $session)
    {
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [

            TextField::new('firstName'),
            TextField::new('lastName'),
            EmailField::new('email')->hideOnIndex(),
            TextField::new('password')->hideOnIndex()->onlyWhenCreating()
        ];
    }

        public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
        {
            //define the role variable
            $role = 'ROLE_MANAGER';

            //filter data displayed in the index with a query: the Administrator can only access to the users with the 'ROLE_MANAGER'
            $qb = $this->container->get(\EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
            $qb->where('entity.roles LIKE :role')
            ->setParameter('role','%"'.$role.'"%');

            return $qb;
        }

        public function new(AdminContext $context)
        {
            $event = new BeforeCrudActionEvent($context);
            $this->container->get('event_dispatcher')->dispatch($event);
            if ($event->isPropagationStopped()) {
                return $event->getResponse();
            }

            if (!$this->isGranted(Permission::EA_EXECUTE_ACTION, ['action' => Action::NEW, 'entity' => null])) {
                throw new ForbiddenActionException($context);
            }

            if (!$context->getEntity()->isAccessible()) {
                throw new InsufficientEntityPermissionException($context);
            }

            $context->getEntity()->setInstance($this->createEntity($context->getEntity()->getFqcn()));
            $this->container->get(EntityFactory::class)->processFields($context->getEntity(), FieldCollection::new($this->configureFields(Crud::PAGE_NEW)));
            $context->getCrud()->setFieldAssets($this->getFieldAssets($context->getEntity()->getFields()));
            $this->container->get(EntityFactory::class)->processActions($context->getEntity(), $context->getCrud()->getActionsConfig());

            $newForm = $this->createNewForm($context->getEntity(), $context->getCrud()->getNewFormOptions(), $context);
            $newForm->handleRequest($context->getRequest());

            $entityInstance = $newForm->getData();
            $context->getEntity()->setInstance($entityInstance);

            if ($newForm->isSubmitted() && $newForm->isValid()) {
                $this->processUploadedFiles($newForm);

                $event = new BeforeEntityPersistedEvent($entityInstance);
                $this->container->get('event_dispatcher')->dispatch($event);
                $entityInstance = $event->getEntityInstance();


                // test password strength : if password is not valid, display flash message for the user
                if(preg_match('^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^',$entityInstance->getPassword())){
                    $this->persistEntity($this->container->get('doctrine')->getManagerForClass($context->getEntity()->getFqcn()), $entityInstance);

                    $this->container->get('event_dispatcher')->dispatch(new AfterEntityPersistedEvent($entityInstance));
                    $context->getEntity()->setInstance($entityInstance);

                    return $this->getRedirectResponseAfterSave($context, Action::NEW);
                }else{
                    $this->session->getFlashbag('')
                        ->add('danger','Veuillez renseigner un mot de passe valide : minimum 8 caratères, une minuscule, une majuscule, un chiffre');
                }
            }

            $responseParameters = $this->configureResponseParameters(KeyValueStore::new([
                'pageName' => Crud::PAGE_NEW,
                'templateName' => 'crud/new',
                'entity' => $context->getEntity(),
                'new_form' => $newForm,
            ]));

            $event = new AfterCrudActionEvent($context, $responseParameters);
            $this->container->get('event_dispatcher')->dispatch($event);
            if ($event->isPropagationStopped()) {
                return $event->getResponse();
            }

            return $responseParameters;
        }


        public function edit(AdminContext $context)
        {
            $event = new BeforeCrudActionEvent($context);
            $this->container->get('event_dispatcher')->dispatch($event);
            if ($event->isPropagationStopped()) {
                return $event->getResponse();
            }

            if (!$this->isGranted(Permission::EA_EXECUTE_ACTION, ['action' => Action::EDIT, 'entity' => $context->getEntity()])) {
                throw new ForbiddenActionException($context);
            }

            if (!$context->getEntity()->isAccessible()) {
                throw new InsufficientEntityPermissionException($context);
            }

            $this->container->get(EntityFactory::class)->processFields($context->getEntity(), FieldCollection::new($this->configureFields(Crud::PAGE_EDIT)));
            $context->getCrud()->setFieldAssets($this->getFieldAssets($context->getEntity()->getFields()));
            $this->container->get(EntityFactory::class)->processActions($context->getEntity(), $context->getCrud()->getActionsConfig());
            $entityInstance = $context->getEntity()->getInstance();

            if ($context->getRequest()->isXmlHttpRequest()) {
                if ('PATCH' !== $context->getRequest()->getMethod()) {
                    return new Response(null, 400);
                }

                if (!$this->isCsrfTokenValid(BooleanField::CSRF_TOKEN_NAME, $context->getRequest()->query->get('csrfToken'))) {
                    return new Response(null, 400);
                }

                $fieldName = $context->getRequest()->query->get('fieldName');
                $newValue = 'true' === mb_strtolower($context->getRequest()->query->get('newValue'));

                try {
                    $event = $this->ajaxEdit($context->getEntity(), $fieldName, $newValue);
                } catch (\Exception $exception) {
                    return new Response(null, 400);
                }

                if ($event->isPropagationStopped()) {
                    return $event->getResponse();
                }

                // cast to integer instead of string to avoid sending empty responses for 'false'
                return new Response((int) $newValue);
            }

            $editForm = $this->createEditForm($context->getEntity(), $context->getCrud()->getEditFormOptions(), $context);
            $editForm->handleRequest($context->getRequest());
            if ($editForm->isSubmitted() && $editForm->isValid()) {
                $this->processUploadedFiles($editForm);

                $event = new BeforeEntityUpdatedEvent($entityInstance);
                $this->container->get('event_dispatcher')->dispatch($event);
                $entityInstance = $event->getEntityInstance();

                if(preg_match('^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^',$entityInstance->getPassword())){
                    $this->updateEntity($this->container->get('doctrine')->getManagerForClass($context->getEntity()->getFqcn()), $entityInstance);
                    $this->container->get('event_dispatcher')->dispatch(new AfterEntityUpdatedEvent($entityInstance));
                    return $this->getRedirectResponseAfterSave($context, Action::EDIT);
                }else{
                    $this->session->getFlashbag('')
                        ->add('danger','Veuillez renseigner un mot de passe valide : minimum 8 caratères, une minuscule, une majuscule, un chiffre');
                }
            }

            $responseParameters = $this->configureResponseParameters(KeyValueStore::new([
                'pageName' => Crud::PAGE_EDIT,
                'templateName' => 'crud/edit',
                'edit_form' => $editForm,
                'entity' => $context->getEntity(),
            ]));

            $event = new AfterCrudActionEvent($context, $responseParameters);
            $this->container->get('event_dispatcher')->dispatch($event);
            if ($event->isPropagationStopped()) {
                return $event->getResponse();
            }

            return $responseParameters;
        }

}
