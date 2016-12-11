<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ProductForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $container = $options['container'];
        $shopCurrency = $container->getParameter('shop_currency');

        $builder
            ->add('name', TextType::class, array(
                'label' => 'Product name:',
                'required' => true,
                'trim' => true,
            ))
            ->add('price', MoneyType::class, array(
                'label' => 'Product price(' . $shopCurrency . '):',
                'required' => true,
                'currency' => null
            ))
            ->add('description', TextareaType::class, array(
                'label' => 'Product desc:',
                'required' => true,
                'trim' => true,
            ))
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('container');
        $resolver->setAllowedTypes('container', 'Symfony\Component\DependencyInjection\ContainerInterface');
    }

}
