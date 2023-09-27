<?php 

namespace App\Form;

use App\Entity\Game;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add('name', options: ['label'=>'Nom du jeu', 'help'=>"Quel est le titre du jeu?"])
            ->add('description', options:['attr'=>['rows'=>10]])
            ->add('releaseDate', options: ['years'=>range(1972,date('Y')+2)])// pour mettre la bonne date
            ->add('category', EntityType::class);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Game::class,]);
    }
}