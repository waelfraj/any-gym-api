<?php

namespace App\Repositories;

use App\Exceptions\Weight\CannotDeleteWeightException;
use App\Exceptions\Weight\CreatingWeightException;
use App\Exceptions\Weight\GetWeightException;
use App\Exceptions\Weight\WeightNotFoundException;
use App\Models\Weight;
use App\Repositories\Interfaces\WeightRepositoryInterface;
use App\Services\AuthService;

class WeightRepository implements WeightRepositoryInterface
{
    public function __construct(private readonly AuthService $authService)
    {
    }

    /**
     * @return mixed
     * @throws GetWeightException
     */
    public function getAllByMember(): mixed
    {
        $userId = $this->authService->getCurrentUser();
        $weights = Weight::where('member_id', $userId)->paginate(5);
        return $weights ?: throw new GetWeightException();
    }

    /**
     * @param $weight
     * @return mixed
     * @throws CreatingWeightException
     */
    public function store($weight): mixed
    {
        $userId = $this->authService->getCurrentUser();
        return Weight::create(
            [
                'weight' => $weight['weight'],
                'member_id' => $userId
            ]) ?: throw new CreatingWeightException();
    }


    /**
     * @param $weightId
     * @return bool
     * @throws CannotDeleteWeightException
     * @throws WeightNotFoundException
     */
    public function delete($weightId): bool
    {
        $weight = $this->findById($weightId);
        $this->canBeDeleted($weight);
        $deleted = $weight->delete();
        return $deleted ? true : throw new CannotDeleteWeightException();
    }

    /**
     * @param $weightId
     * @return mixed
     * @throws WeightNotFoundException
     */
    private function findById($weightId): mixed
    {
        return Weight::findOr($weightId, fn() => throw new WeightNotFoundException());

    }

    /**
     * @param $weight
     * @return void
     * @throws CannotDeleteWeightException
     */
    private function canBeDeleted($weight): void
    {
        $userId = $this->authService->getCurrentUser();
        if ($weight->member_id != $userId) {
            throw new CannotDeleteWeightException();
        }
    }
}
