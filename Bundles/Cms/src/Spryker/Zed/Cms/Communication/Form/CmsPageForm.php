<?php

/**
 * (c) Spryker Systems GmbH copyright protected.
 */

namespace Spryker\Zed\Cms\Communication\Form;

use Spryker\Zed\Cms\Dependency\Facade\CmsToUrlInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Required;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class CmsPageForm extends AbstractType
{

    const FIELD_ID_CMS_PAGE = 'idCmsPage';
    const FIELD_FK_TEMPLATE = 'fkTemplate';
    const FIELD_URL = 'url';
    const FIELD_CURRENT_TEMPLATE = 'cur_temp';
    const FIELD_IS_ACTIVE = 'is_active';
    const FIELD_ID_URL = 'id_url';

    const OPTION_TEMPLATE_CHOICES = 'template_choices';
    const GROUP_UNIQUE_URL_CHECK = 'unique_url_check';

    /**
     * @var \Spryker\Zed\Cms\Dependency\Facade\CmsToUrlInterface
     */
    protected $urlFacade;

    /**
     * @param \Spryker\Zed\Cms\Dependency\Facade\CmsToUrlInterface $urlFacade
     */
    public function __construct(CmsToUrlInterface $urlFacade)
    {
        $this->urlFacade = $urlFacade;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cms_page';
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
     *
     * @return void
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setRequired(self::OPTION_TEMPLATE_CHOICES);

        $resolver->setDefaults([
            'validation_groups' => function(FormInterface $form) {
                $defaultData = $form->getConfig()->getData();
                if (
                    array_key_exists(self::FIELD_URL, $defaultData) === false ||
                    $defaultData[self::FIELD_URL] !== $form->getData()[self::FIELD_URL]
                ) {
                    return [Constraint::DEFAULT_GROUP, self::GROUP_UNIQUE_URL_CHECK];
                }
                return [Constraint::DEFAULT_GROUP];
            }
        ]);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this
            ->addIdCmsPageField($builder)
            ->addIdUrlField($builder)
            ->addCurrentTemplateField($builder, $options[self::OPTION_TEMPLATE_CHOICES])
            ->addFkTemplateField($builder)
            ->addUrlField($builder)
            ->addIsActiveField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return self
     */
    protected function addIdCmsPageField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_ID_CMS_PAGE, 'hidden');

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return self
     */
    protected function addFkTemplateField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_ID_URL, 'hidden');

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return self
     */
    protected function addUrlField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_CURRENT_TEMPLATE, 'hidden');

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array $choices
     *
     * @return self
     */
    protected function addCurrentTemplateField(FormBuilderInterface $builder, array $choices)
    {
        $builder->add(self::FIELD_FK_TEMPLATE, 'choice', [
            'label' => 'Template',
            'choices' => $choices,
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return self
     */
    protected function addIdUrlField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_URL, 'text', [
            'label' => 'URL',
            'constraints' => $this->getUrlConstraints(),
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return self
     */
    protected function addIsActiveField(FormBuilderInterface $builder)
    {
        $builder->add(self::FIELD_IS_ACTIVE, 'checkbox', [
            'label' => 'Active',
        ]);

        return $this;
    }

    /**
     * @return array
     */
    protected function getUrlConstraints()
    {
        $urlConstraints = [
            new Required(),
            new NotBlank(),
            new Length(['max' => 255]),
            new Callback([
                'methods' => [
                    function ($url, ExecutionContextInterface $context) {
                        if ($this->urlFacade->hasUrl($url)) {
                            $context->addViolation('Url is already used');
                        }
                    },
                ],
                'groups' => [self::GROUP_UNIQUE_URL_CHECK],
            ]),
        ];

        return $urlConstraints;
    }

}