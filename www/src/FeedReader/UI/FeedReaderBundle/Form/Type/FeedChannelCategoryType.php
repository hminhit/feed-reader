<?php
namespace FeedReader\UI\FeedReaderBundle\Form\Type;

use Symfony\Component\Form\AbstractType
    , Symfony\Component\Form\FormBuilderInterface
    , Symfony\Component\Form\Extension\Core\Type\TextType
    , Symfony\Component\Form\Extension\Core\Type\HiddenType
    , Symfony\Component\Validator\Constraints\NotBlank;

class FeedChannelCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'categoryId'
                , HiddenType::class
                , [
                    'required' => false
                    , 'error_bubbling' => true
                ]
            )
            ->add(
                'categoryName'
                , TextType::class
                , [
                    'required' => false
                    , 'error_bubbling' => true
                    , 'constraints' => [
                        new NotBlank()
                    ]
                ]
            )
            ->add(
                'categoryDomain'
                , TextType::class
                , [
                    'required' => false
                    , 'error_bubbling' => true
                ]
            )
        ;
    }

    public function getName()
    {
        return 'channel_category';
    }
}