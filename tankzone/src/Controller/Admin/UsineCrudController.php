<?php

namespace App\Controller\Admin;

use App\Entity\Usine;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class UsineCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Usine::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            //IdField::new('id'),
            TextField::new('name'),
            TextField::new('description'),
            BooleanField::new('active'),

            AssociationField::new('tanks'),
            AssociationField::new('member')
        ];
    }
}