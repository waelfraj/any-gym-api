<?php

namespace App\Services;

use App\Repositories\Interfaces\MemberRepositoryInterface;
use App\Repositories\Interfaces\TrainingListRepositoryInterface;
use Symfony\Component\CssSelector\Exception\InternalErrorException;

class MemberService
{
    public function __construct(
        private readonly MemberRepositoryInterface       $memberRepository,
        private readonly TrainingListRepositoryInterface $trainingListRepository,
        private readonly AuthService                     $authService
    )
    {
    }

    public function getAll()
    {
        return $this->memberRepository->getAll();
    }

    public function getLastThree()
    {
        return $this->memberRepository->getlastThree();
    }

    public function showById($id)
    {
        return $this->memberRepository->getById($id);
    }

    public function create($member)
    {
        return $this->memberRepository->create($member);
    }

    public function searchByName($name)
    {
        return $this->memberRepository->searchByName($name);
    }

    public function destroy($id)
    {
        return $this->memberRepository->destroy($id);
    }

    public function getNumberOfMembers()
    {
        return $this->memberRepository->getNumberOfMembers();
    }

    public function validateMember($id)
    {
        return $this->memberRepository->validateMember($id);
    }

    /**
     * @param $memberDetails
     * @return mixed
     */
    public function completeProfile($memberDetails): mixed
    {
        return $this->memberRepository->completeProfile($memberDetails);
    }


    /**
     * @param $trainingId
     * @return bool
     */
    public function attachMemberToTrainingList($trainingId): bool
    {
        return $this->trainingListRepository->attachMember($trainingId);
    }

    /**
     * @return array|string
     * @throws InternalErrorException
     */
    public function getMemberToTrainingList(): array|string
    {
        try {
            $userId = $this->authService->getCurrentUser();
            $trainingLists = $this->trainingListRepository->getTrainingListByMemberId($userId);
            $formattedData = $this->formatData($trainingLists);
            if (!empty($formattedData)) {
                return $formattedData;
            } else {
                return 'Aucune liste d\'entraînement trouvée pour ce membre.';
            }
        } catch (InternalErrorException $e) {
            throw new InternalErrorException();
        }
    }

    /**
     * @param $trainingLists
     * @return array
     */
    private function formatData($trainingLists): array
    {
        // Initialiser le tableau formaté
        $formattedData = [];

        // Regrouper les listes d'entraînement par jour, mois et année
        foreach ($trainingLists as $item) {
            if (isset($item['members']) && count($item['members']) > 0) {
                foreach ($item['members'] as $member) {
                    // Récupérer la date de création à partir de chaque entrée pivot
                    $pivotCreatedAt = $member['pivot']->created_at->format('Y-m-d');

                    // Construire l'élément formaté
                    $formattedItem = [
                        'id' => $item['id'],
                        'coach' => $item->coach->user->name,
                        'title' => $item['title'],
                        'description' => $item['description'],
                        'image' => $item['image'],
                        'is_reserved' => $item['is_reserved'],
                        'total_calories' => $item['total_calories'],
                        'difficulty' => $item['difficulty'],
                        'created_at' => $item['created_at'],
                        'updated_at' => $item['updated_at']
                    ];

                    // Ajouter l'élément formaté à l'entrée correspondante du tableau formaté
                    if (!isset($formattedData[$pivotCreatedAt])) {
                        $formattedData[$pivotCreatedAt] = [];
                    }
                    $formattedData[$pivotCreatedAt][] = $formattedItem;
                }
            }
        }
        return $formattedData;
    }
}
