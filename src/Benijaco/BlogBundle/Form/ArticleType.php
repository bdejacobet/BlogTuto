<?php

namespace Benijaco\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date',        'date')
            ->add('titre',       'text')
            ->add('contenu',     'textarea')
            ->add('auteur',      'text')
            ->add('publication', 'checkbox', array('required' => false))
            ->add('image',        new ImageType())
            ->add('categories', 'collection', array('type'         => new CategorieType(),
                                              'allow_add'    => true,
                                              'allow_delete' => true,
                                              'by_reference' => false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Benijaco\BlogBundle\Entity\Article'
        ));
    }

    public function getName()
    {
        return 'benijaco_blogbundle_articletype';
    }
}
