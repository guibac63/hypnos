<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Security\Voter\ManagerCreateVoter;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
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
            TextField::new('password')->hideOnIndex()
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

}
