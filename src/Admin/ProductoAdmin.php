<?php

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\DoctrineORMAdminBundle\Filter\DateRangeFilter;

use App\Entity\Categoria;


final class ProductoAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->add('nombre', TextType::class, array('required' => true));
        $formMapper->add('descripcion', TextareaType::class, array('required' => false));
        $formMapper->add('categoria', ModelType::class, array(
            'class' => Categoria::class,
            'property' => 'nombre',
            'required' => true));
        /*
        $formMapper->add('fotos', CollectionType::class, [
            'entry_type' => ColorType::class,
            'label' => 'Variantes',
            'allow_add' => true,
            'allow_delete' => true,
            'entry_options' => [
                'attr' => ['class' => 'email-box'],
            ],
        ]);
        */
        $formMapper->add('fotos', FileType::class, array(
            'multiple'=> true,
            'label' => 'Variantes',
            'required' => true));
        $formMapper->add('precio_unidad', MoneyType::class, [
            'currency' => 'USD',
            'label' => 'Precio de la unidad',
            'required' => true
        ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('nombre');
        $datagridMapper->add('categoria.nombre', null, array('label' => 'Categoria'));
        $datagridMapper->add('precio_unidad', null, array('label' => 'Precio por unidad'));
        $datagridMapper->add('fecha_creacion', DateRangeFilter::class, array('label' => 'Creado'));
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('nombre');
        //$listMapper->addIdentifier('descripcion');
        $listMapper->addIdentifier('categoria.nombre', null, array('label' => 'Categoria'));
        $listMapper->addIdentifier('precio_unidad', null, array('label' => 'Precio por unidad'));
        $listMapper->addIdentifier('fecha_creacion', null, array('label' => 'Creado'));
    }
}