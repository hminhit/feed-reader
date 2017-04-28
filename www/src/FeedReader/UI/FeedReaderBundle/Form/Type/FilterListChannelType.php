<?php
namespace FeedReader\UI\FeedReaderBundle\Form\Type;

use FeedReader\Application\Command\ListFeedChannelCommand
    , Symfony\Bridge\Doctrine\Form\Type\EntityType
    , Symfony\Component\Form\AbstractType
    , Symfony\Component\Form\FormBuilderInterface
    , Symfony\Component\Form\DataMapperInterface
    , Symfony\Component\OptionsResolver\OptionsResolver;

class FilterListChannelType extends AbstractType implements DataMapperInterface
{
    protected $feedChannelCommand;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->feedChannelCommand = $options['listFeedChannelCommand'];
        $builder
            ->setMethod('GET')
            ->setDataMapper($this)
            ->add(
                'feedChannelCategory'
                , EntityType::class
                , [
                    'class' => 'FeedReader\Domain\Model\Feed\FeedChannelCategory'
                    , 'choice_label' => 'categoryName'
                    , 'placeholder' => 'Choose your feed channel category'
                    , 'required' => true
                ]
            );
    }

    public function mapDataToForms($data, $forms)
    {
        $forms = iterator_to_array($forms);
        $data = $this->feedChannelCommand;
        $forms['feedChannelCategory']->setData($data->channelCategoryId());
    }

    public function mapFormsToData($forms, &$data)
    {
        $data = new ListFeedChannelCommand(
            $this->feedChannelCommand->pageNumber()
            , $this->feedChannelCommand->channelCategoryId()
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setRequired(['listFeedChannelCommand'])
            ->setDefaults(
                [
                    'csrf_protection' => false
                    , 'empty_data' => false
                ]
            );
    }

    public function getBlockPrefix()
    {
        return 'filter_list_channel';
    }
}