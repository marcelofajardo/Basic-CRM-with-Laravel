<?php

namespace App\Policies;

use App\Company;
use App\Employee;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class EmployeePolicy
{
    use HandlesAuthorization;

    /**
     * @param $user
     * @param $ability
     * @return bool
     */
    public function before(User $user, $ability)
    {
        if ($user->isAdministrator()) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any employees.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the employee.
     *
     * @param User $user
     * @param  \App\Employee  $employee
     * @return mixed
     */
    public function view(User $user, Employee $employee)
    {
        //
    }

    /**
     * Determine whether the user can create employees.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the employee.
     *
     * @param User $user
     * @param  \App\Employee  $employee
     * @return mixed
     */
    public function update(User $user, Employee $employee)
    {
        $userCompanies = $user->companies()->pluck('companies.id');

        return $userCompanies->contains($employee->company_id)
            ? Response::allow() : Response::deny('You do not have permission to update an employee for this company.');
    }

    /**
     * Determine whether the user can delete the employee.
     *
     * @param User $user
     * @param  \App\Employee  $employee
     * @return mixed
     */
    public function delete(User $user, Employee $employee)
    {
        $userCompanies = $user->companies()->pluck('companies.id');

        return $userCompanies->contains($employee->company_id)
            ? Response::allow() : Response::deny('You do not have permission to update an employee for this company.');
    }

    /**
     * Determine whether the user can restore the employee.
     *
     * @param User $user
     * @param  \App\Employee  $employee
     * @return mixed
     */
    public function restore(User $user, Employee $employee)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the employee.
     *
     * @param User $user
     * @param  \App\Employee  $employee
     * @return mixed
     */
    public function forceDelete(User $user, Employee $employee)
    {
        //
    }
}
