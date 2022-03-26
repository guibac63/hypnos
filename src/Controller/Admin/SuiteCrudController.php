<?php

namespace App\Controller\Admin;

use App\Entity\Suite;
use App\Form\GalleryType;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Security\Core\Security;
use Vich\UploaderBundle\Form\Type\VichImageType;

class SuiteCrudController extends AbstractCrudController
{

    private $security;

    public function __construct(Security $security){
        $this->security = $security;
    }

    public static function getEntityFqcn(): string
    {
        return Suite::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextEditorField::new('description'),
            MoneyField::new('price')->setCurrency('EUR'),
            TextField::new('link'),
            TextField::new('imageFile')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('main_image')->setBasePath('/images/suites/')->hideOnForm(),
            CollectionField::new('galleries')
                ->setEntryType(GalleryType::class)
                ->setFormTypeOption('by_reference',false)
                ->onlyOnForms(),
            CollectionField::new('galleries')
                ->onlyOnDetail()
                ->setTemplatePath('gallery.html.twig')
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(CRUD::PAGE_INDEX,'detail');
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        //define the the id of the establishment managed by the connected user
        $etablissement = $this->security->getUser()->getManager()->getEtablissement()->getId();
        //dd($etablissement);

        //filter data displayed in the index with a query: the Administrator can only access to the users with the 'ROLE_MANAGER'
        $qb = $this->container->get(\EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $qb->andWhere(':etablissement = entity.etablissement')
        ->setParameter('etablissement',$etablissement);
        return $qb;
    }

}
