<?php

namespace App\Form;

use App\Entity\Shop;
use App\Entity\TV;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TvType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('tv_code')
            ->add('screen_size')
            ->add('smarttv')
            ->add('fabdate', null, [
                'widget' => 'single_text',
            ])
            ->add('price')
            ->add('shop', EntityType::class, [
                'class' => Shop::class,
                'choice_label' => 'id',
                'multiple' => false,
                'expanded' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TV::class,
        ]);
    }
}
