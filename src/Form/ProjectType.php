<?php

namespace App\Form;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            //Pour que le contenu du champs sol soit le contenu de la constante GROUND
            ->add('ground', ChoiceType::class, [
                    'choices'=>$this->getChoices()                
    ])
            ->add('area') 
            ->add('user')        
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
            //Pour changer l'intitulé au niveau de la langue via le fichier translations
            'translation_domain' =>'forms'
        ]);
    }
    //Methode pour récupérer toutes les valeurs de ma constante GROUND dans Project
    public function getChoices(){
        $choices = Project::GROUND;
        $output = [];
        foreach($choices as $k => $v){
            $output[$v] = $k;
        }
        return $output;
     }
}
