<?php
namespace App\Repository\V1;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface IRepository
{
    public function all(): Collection;
    public function find(int $id);
    public function create(array $data);
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;
}
?>
