<?php 

namespace App\Form;

use App\Entity\Category;
use App\Entity\Game;
use App\Entity\Support;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class GameType extends AbstractType
{
    public function __construct(private Security $security)
    {
        
    }
    /**
     * @JoinColumn(name="game_id", referencedColumnName="id")
     */
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add('name', options: ['label'=>'Nom du jeu', 'help'=>"Quel est le titre du jeu?"])
            ->add('description', options:['attr'=>['rows'=>10]])
            ->add('releaseDate', options: ['years'=>range(1972,date('Y')+2)])// pour mettre la bonne date
            ->add('category', EntityType::class, [
                // looks for choices from this entity
                'class' => Category::class,
            
                // uses the User.username property as the visible option string
                'choice_label' => 'name',
            
                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ])
            ->add('support', EntityType::class, [

                'class'=>Support::class,
                'choice_label'=>'name',
                
                'multiple'=>true, 
                
                'expanded'=>true,
                'query_builder' => function (EntityRepository $er) : QueryBuilder {
                    return $er->createQueryBuilder('s')->orderBy('s.constructor', 'ASC');
             }]
            );
            
            // ajouter le champ seulement si l'utilisateur est admin
            if ($this->security->isGranted('ROLE_ADMIN')){
                $builder->add('published');
            }
            
            

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Game::class,]);
    }
}