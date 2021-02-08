<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Wish;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ["label"=>"titre"])
            ->add('description',null, ["label"=>"description"])
            ->add('author',null, ["label"=>"auteur"])
            ->add('category',EntityType::class, [
                'class'=>Category::class,
                'choice_label'=>'name',
                'multiple'=>false,
                'expanded'=>true,
                "label"=>"catégorie"
            ])
            //->add('isPublished')
            //->add('dateCreated')
            ->add('submit', SubmitType::class,  ["label"=>"valider"])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Wish::class,
        ]);
    }
}
