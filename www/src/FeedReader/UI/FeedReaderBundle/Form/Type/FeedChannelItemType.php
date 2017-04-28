<?php
namespace FeedReader\UI\FeedReaderBundle\Form\Type;

use Symfony\Component\Form\AbstractType
    , Symfony\Component\Form\FormBuilderInterface
    , Symfony\Component\Form\Extension\Core\Type\TextType
    , Symfony\Component\Form\Extension\Core\Type\HiddenType
    , Symfony\Component\Form\Extension\Core\Type\TextareaType
    , Symfony\Component\Form\FormEvent
    , Symfony\Component\Form\FormEvents;

class FeedChannelItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'itemId'
                , HiddenType::class
                , [
                    'required' => false
                    , 'error_bubbling' => true
                ]
            )
            ->add(
                'itemTitle'
                , TextType::class
                , [
                    'required' => false
                    , 'error_bubbling' => true
                ]
            )
            ->add(
                'itemDescription'
                , TextareaType::class
                , [
                    'required' => false
                    , 'error_bubbling' => true
                ]
            );

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();
            if (null === $data) {
                return;
            }
            if (
                empty($data['itemTitle'])
                && empty($data['itemDescription'])
            ) {
                $form->get('itemTitle')->addError(
                    new FormError('Item title or Item description one of two fields is required.')
                );
            }
        });
    }

    public function getName()
    {
        return 'channel_item';
    }
}