<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Commentaires;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('message')
            //->add('date', null, [
               // 'widget' => 'single_text',
               // 'required'=>false
           // ])
            //->add('name', EntityType::class, [
                //'class' => User::class,
                //'choice_label' => 'id',
           // ])
            //->add('article', EntityType::class, [
               // 'class' => Article::class,
                //'choice_label' => 'id',
           // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commentaires::class,
        ]);
    }
}
