<?php

namespace AppBundle\Form;

use AppBundle\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompanyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                ['label' => 'price_rule_names.name', 'attr' => $options['attr']]
            )
            ->add(
                'description',
                TextareaType::class,
                ['label' => 'price_rule_names.description', 'required' => false, 'attr' => $options['attr']]
            );
//            ->add('createBy')
//            ->add('createDate', DateTimeType::class)
//            ->add('modifyBy')
//            ->add('modifyDate', DateTimeType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Company::class
        ));
    }
}
