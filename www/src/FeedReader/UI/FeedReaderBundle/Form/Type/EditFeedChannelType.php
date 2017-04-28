<?php
namespace FeedReader\UI\FeedReaderBundle\Form\Type;

use FeedReader\Application\Command\EditFeedChannelCommand
    , FeedReader\Domain\Model\Feed\FeedChannelCategory
    , FeedReader\Domain\Model\Feed\FeedChannelItem
    , FeedReader\Domain\Model\Feed\FeedChannelItemCategory
    , Symfony\Component\Form\AbstractType
    , Symfony\Component\Form\FormBuilderInterface
    , Symfony\Component\Form\Extension\Core\Type\TextType
    , Symfony\Component\Form\DataMapperInterface
    , Symfony\Component\Form\Extension\Core\Type\CollectionType
    , Symfony\Component\Form\Extension\Core\Type\TextareaType
    , Symfony\Component\OptionsResolver\OptionsResolver
    , Symfony\Component\Validator\Constraints\NotBlank;

class EditFeedChannelType extends AbstractType implements DataMapperInterface
{
    /**
     * @var EditFeedChannelCommand
     */
    protected $editFeedChannelCommand;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->editFeedChannelCommand = $options['editFeedChannelCommand'];
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
     * @param \Symfony\Component\Form\FormInterface[] $forms
     */
    public function mapDataToForms($data, $forms)
    {
        if ($data === null) {
            $data = $this->editFeedChannelCommand;
        }
        $forms = iterator_to_array($forms);
        $forms['channelTitle']->setData($data->existingFeedChannel()->channelTitle());
        $forms['channelLink']->setData($data->existingFeedChannel()->channelLink());
        $forms['channelDescription']->setData($data->existingFeedChannel()->channelDescription());
        $forms['channelCategory']->setData(
            array_map(
                function (FeedChannelCategory $feedChannelCategory) {
                    return [
                        'categoryId' => $feedChannelCategory->id()->id()
                        , 'categoryName' => $feedChannelCategory->categoryName()
                        , 'categoryDomain' => $feedChannelCategory->categoryDomain()
                    ];
                }
                , iterator_to_array($data->existingFeedChannel()->channelCategory())
            )
        );
        $forms['channelItem']->setData(
            array_map(
                function (FeedChannelItem $feedChannelItem) {
                    return [
                        'itemId' => $feedChannelItem->id()->id()
                        , 'itemTitle' => $feedChannelItem->itemTitle()
                        , 'itemDescription' => $feedChannelItem->itemDescription()
                    ];
                }
                , iterator_to_array($data->existingFeedChannel()->channelItem())
            )
        );
    }

    /**
     * @param FormInterface[] $forms
     * @param mixed $data
     */
    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);
        $data = new EditFeedChannelCommand(
            $this->editFeedChannelCommand->feedChannelId()
            , $this->editFeedChannelCommand->existingFeedChannel()
            , $forms['channelTitle']->getData()
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
        $resolver
            ->setRequired(['editFeedChannelCommand'])
            ->setDefaults(
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