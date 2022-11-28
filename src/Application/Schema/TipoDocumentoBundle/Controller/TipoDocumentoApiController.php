<?php

namespace App\Application\Schema\TipoDocumentoBundle\Controller;

use App\Application\Schema\TipoDocumentoBundle\Repository\TipoDocumentoRepository;
use App\Application\Schema\TipoDocumentoBundle\Entity\TipoDocumento;

use App\Application\Project\ContentBundle\Controller\Base\BaseApiController;
use App\Application\Project\ContentBundle\Service\FilterDoctrine;
use App\Application\Project\ContentBundle\Attributes\Acl as ACL;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ObjectRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\QueryException;
use OpenApi\Attributes as OA;

#[Route('/api/tipoDocumento', name: 'api_tipoDocumento_')]
#[OA\Tag(name: 'TipoDocumento')]
#[ACL\Api(enable: true, title: 'TipoDocumento', description: 'Permissões do modulo TipoDocumento')]
class TipoDocumentoApiController extends BaseApiController
{

    public function getClass(): string
    {
        return TipoDocumento::class;
    }

    public function getRepository(): ObjectRepository
    {
        return $this->doctrine->getManager()->getRepository($this->getClass());
    }







    /** ****************************************************************************************** */
    /**
     * Substitui o recurso — TipoDocumento.
     * Substitui o recurso — TipoDocumento.
     */
    #[OA\Parameter( name: 'id', description: 'Identificador do recurso', in: 'path')]
    #[OA\Response(
        response: 200,
        description: 'Retorna recurso TipoDocumento',
        content: new OA\JsonContent(
            properties: [
    new OA\Property(property: 'id', type: 'integer'),
    new OA\Property(property: 'tipo', type: 'string'),
    new OA\Property(property: 'descricao', type: 'string'),
                new OA\Property(property: 'id', type: 'integer'),
                new OA\Property(property: 'titulo', type: 'string', nullable: false),
                new OA\Property(property: 'decricao', type: 'string'),
                new OA\Property(property: 'tipoDocumento', type: 'integer'),
                new OA\Property(property: 'autor', type: 'array', items: new OA\Items(type: 'integer')),
            ],
            type: 'object'
        )
    )]
    #[OA\Response(response: 400, description: 'Dados inválidos!')]
    #[OA\Response(response: 404, description: 'Recurso não encontrado')]
    #[OA\RequestBody(
        description: 'Json Payload',
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: 'titulo', type: 'string'),
                new OA\Property(property: 'decricao', type: 'string'),
                new OA\Property(property: 'tipoDocumento', type: 'integer'),
                new OA\Property(property: 'autor', type: 'array', items: new OA\Items(type: 'integer')),
            ],
            type: 'object'
        )
    )]
    #[Route('/{id}', name: 'edit', methods: ['PUT','PATCH'])]
    #[ACL\Api(enable: true, title: 'Editar', description: 'Editar TipoDocumento')]
    public function editAction(Request $request, int $id): Response
    {
        //$this->validateAccess("editAction");

        $object = $this->getRepository()->find($id);
        if(!$object)
            return $this->json(['status' => false, 'message' => 'TipoDocumento não encontrado!'], 404);

        /** Transforma corpo da requisição em um objeto da classe. */
        $object = $this->objectTransformer->JsonToObject($object, $request , [
            'id', 'titulo', 'decricao', 'tipoDocumento', 'autor', 'imagem',
        ]);

        /** Valida Restrições do objeto */
        $errors = $this->validateConstraintErros($object);
        if($errors)
            return $this->json($errors);

        /** Persiste o objeto */
        $em = $this->doctrine->getManager();
        $em->persist($object);
        $em->flush();

        $response = $this->objectTransformer->ObjectToJson( $object, [
            'id', 'titulo', 'decricao',
            'tipoDocumento' => [ 'id', 'tipo' ],
            'autor' => [ 'id', 'nome' ],
            'imagem' => [ 'id' ]
        ]);

        return $this->json($response);
    }

    /** ****************************************************************************************** */
    /**
    * Remove o recurso — TipoDocumento.
    * Remove o recurso — TipoDocumento.
    */
    #[OA\Parameter( name: 'id', description: 'Identificador do recurso', in: 'path')]
    #[OA\Response(response: 204, description: 'Recurso excluído')]
    #[OA\Response(response: 404, description: 'Recurso não encontrado')]
    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    #[ACL\Api(enable: true, title: 'Deletar', description: 'Deletar TipoDocumento')]
    public function deleteAction(int $id): Response
    {
        $this->validateAccess("deleteAction");

        $object = $this->getRepository()->find($id);
        if (!$object)
            return $this->json(['status' => false, 'message' => 'TipoDocumento não encontrado.'], 404);

        $em = $this->doctrine->getManager();
        $em->remove($object);
        $em->flush();

        return $this->json(['status' => true, 'message' => 'TipoDocumento removido com sucesso.'], 204);
    }

}