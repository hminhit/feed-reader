<?php
namespace FeedReader\UI\FeedReaderBundle\Form\Type;

use FeedReader\Application\Command\AddFeedChannelCommand
    , Symfony\Component\Form\AbstractType
    , Symfony\Component\Form\FormBuilderInterface
    , Symfony\Component\Form\Extension\Core\Type\TextType
    , Symfony\Component\Form\DataMapperInterface
    , Symfony\Component\Form\Extension\Core\Type\CollectionType
    , Symfony\Component\Form\Extension\Core\Type\TextareaType
    , Symfony\Component\Form\FormInterface
    , Symfony\Component\OptionsResolver\OptionsResolver
    , Symfony\Component\Validator\Constraints\NotBlank;

class AddFeedChannelType extends AbstractType implements DataMapperInterface
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setDataMapper($this)
            ->add(
                'channelTitle'
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
                'channelLink'
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
                'channelDescription'
                , TextareaType::class
                , [
                    'required' => false
                    , 'error_bubbling' => true
                    , 'constraints' => [
                        new NotBlank()
                    ]
                ]
            )
            ->add(
                'channelCategory'
                , CollectionType::class
                , [
                    'required' => false
                    , 'error_bubbling' => true
                    , 'entry_type' => FeedChannelCategoryType::class
                    , 'allow_add' => true
                    , 'allow_delete' => true
                ]
            )
            ->add(
                'channelItem'
                , CollectionType::class
                , [
                    'required' => false
                    , 'error_bubbling' => true
                    , 'entry_type' => FeedChannelItemType::class
                    , 'allow_add' => true
                    , 'allow_delete' => true
                ]
            );
    }

    /**
     * @param mixed $data
     * @param FormInterface[] $forms
     */
    public function mapDataToForms($data, $forms)
    {

    }

    /**
     * @param FormInterface[] $forms
     * @param mixed $data
     */
    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);
        $data = new AddFeedChannelCommand(
            $forms['channelTitle']->getData()
            , $forms['channelLink']->getData()
            , $forms['channelDescription']->getData()
            , $forms['channelCategory']->getData()
            , $forms['channelItem']->getData()
        );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'empty_data' => null
            ]
        );
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'feed_channel';
    }
}