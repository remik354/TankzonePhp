<?php

namespace App\Controller\Admin;

use App\Entity\Usine;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class UsineCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Usine::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            // IntegerField::new('id'),
            TextField::new('name'),
            TextField::new('description'),
            BooleanField::new('public'),

            AssociationField::new('tanks'),
            AssociationField::new('member')
        ];
    }
}