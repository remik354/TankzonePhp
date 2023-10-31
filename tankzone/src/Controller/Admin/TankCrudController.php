<?php

namespace App\Controller\Admin;

use App\Entity\Tank;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class TankCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tank::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            //IdField::new('id'),
            TextField::new('name'),
            IntegerField::new('year'),
            TextField::new('origine'),
            IntegerField::new('weight'),
            IntegerField::new('value'),

            AssociationField::new('garage')
        ];
    }
}