<?php
namespace App\Application\Schema\AutorBundle\Admin;

use App\Application\Schema\AutorBundle\Entity\Autor;
use App\Application\Schema\DocumentoBundle\Entity\Documento;

use App\Application\Project\ContentBundle\Admin\Base\BaseAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/** Components Form */
use Sonata\DoctrineORMAdminBundle\Filter\ModelFilter;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;

final class AutorAdmin extends BaseAdmin
{

    public function toString(object $object): string
    {
        return $object instanceof Autor ? $object->getId()
        .' - '.$object->getNome().' - '.$object->getSobrenome()
        : '';
    }



    protected function configureFormFields(FormMapper $form): void
    {
        $form->tab('Geral');
            $form->with('Informações Gerais');


                $form->add('nome',  TextType::class, [
                    'label' => 'Nome',
                    'required' =>  true ,
                ]);

                $form->add('sobrenome',  TextType::class, [
                    'label' => 'Sobrenome',
                    'required' =>  true ,
                ]);

                $form->add('email',  TextType::class, [
                    'label' => 'Email',
                    'required' =>  true ,
                ]);

                $form->add('revisores', ModelAutocompleteType::class, [
                    'property' => 'id',
                    'placeholder' => 'Escolha o Revisores',
                    'help' => 'Filtros para pesquisa: [ id, nome, sobrenome, email,  ] - Exemplo de utilização: [ filtro=texto_pesquisa ]',
                    'minimum_input_length' => 0,
                    'items_per_page' => 10,
                    'quiet_millis' => 100,
                    'multiple' =>  true ,
                    'required' =>  false ,
                    'to_string_callback' => function($entity, $property) {
                        return $entity->getId() .' - '.$entity->getNome().' - '.$entity->getSobrenome();
                    },
                    'callback' => static function (AdminInterface $admin, string $property, string $value): void {
                        $property = strtolower($property);
                        $value = strtolower($value);
                        $datagrid = $admin->getDatagrid();
                        $valueParts = explode('=', $value);
                        if (count($valueParts) === 2 && in_array($valueParts[0], [ "id","nome","sobrenome","email", ]))
                        [$property, $value] = $valueParts;

                        $datagrid->setValue($datagrid->getFilter($property)->getFormName(), null, $value);
                    },
                ]);


            $form->end();
        $form->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagrid): void
    {
        $datagrid->add('id', null, [
            'label' => 'Id',
        ]);

        $datagrid->add('nome', null, [
            'label' => 'Nome',
        ]);

        $datagrid->add('sobrenome', null, [
            'label' => 'Sobrenome',
        ]);

        $datagrid->add('email', null, [
            'label' => 'Email',
        ]);

        $datagrid->add('revisores', ModelFilter::class, [
            'label' => 'Revisores',
            'field_options' => [
                'multiple' => true,
                'choice_label'=> function (Autor $revisores) {
                    return $revisores->getId()
                    .' - '.$revisores->getNome()
                    .' - '.$revisores->getSobrenome()
                    ;
                },
            ],
        ]);

    $datagrid->add('documentos', ModelFilter::class, [
        'label' => 'Documentos',
        'field_options' => [
            'multiple' => true,
            'choice_label'=> function (Documento $documentos) {
                return $documentos->getId()
                .' - '.$documentos->getTitulo()
                ;
            },
        ],
    ]);

    }

    protected function configureListFields(ListMapper $list): void
    {

        $list->addIdentifier('id', null, [
            'label' => 'Id',
        ]);


        $list->addIdentifier('nome', null, [
            'label' => 'Nome',
        ]);


        $list->addIdentifier('sobrenome', null, [
            'label' => 'Sobrenome',
        ]);


        $list->addIdentifier('email', null, [
            'label' => 'Email',
        ]);


        $list->add('revisores', null, [
            'label' => 'Revisores',
            'associated_property' => function (Autor $revisores) {
                return $revisores->getId()
                .' - '.$revisores->getNome()
                .' - '.$revisores->getSobrenome()
                ;
            },
        ]);




        $list->add(ListMapper::NAME_ACTIONS, ListMapper::TYPE_ACTIONS, [
            'actions' => [
                'show'   => [],
                'edit'   => [],
                'delete' => [],
            ]
        ]);

    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show->tab('Geral');
            $show->with('Informações Gerais', [
                'class'       => 'col-md-12',
                'box_class'   => 'box box-solid box-primary',
                'description' => 'Informações Gerais',
            ]);

                $show->add('id', null, [
                    'label' => 'Id',
                ]);

                $show->add('nome', null, [
                    'label' => 'Nome',
                ]);

                $show->add('sobrenome', null, [
                    'label' => 'Sobrenome',
                ]);

                $show->add('email', null, [
                    'label' => 'Email',
                ]);

                $show->add('revisores', null, [
                    'label' => 'Revisores',
                    'associated_property' => function (Autor $revisores) {
                        return $revisores->getId()
                        .' - '.$revisores->getNome()
                        .' - '.$revisores->getSobrenome()
                        ;
                    },
                ]);



            $show->end();
        $show->end();
    }


}