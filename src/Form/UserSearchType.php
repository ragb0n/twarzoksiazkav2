<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder //tworzymy formularz z pustym polem "searchKeyword", niezmapowanym z żadnym polem z istniejącej tabeli
            ->add('searchKeyword', TextType::class, [
                'label' => ' ',
                'required' => true,
            ]);
    }


}
