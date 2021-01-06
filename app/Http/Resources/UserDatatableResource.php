<?php

namespace App\Http\Resources;

use Collective\Html\FormFacade as Form;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDatatableResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $edit = '';
        if (hasPermission('user','write')) {
            $edit = "<a href='" . route('users.edit', $this->id) . "'
						class='btn btn-default btn-sm btn-edit-action'
						data-title='Edit' data-toggle='tooltip' data-placement='top'>
						<i class='fas fa-pen text-primary'></i>
					</a>&nbsp;";
        }

        $delete = '';
        if (hasPermission('user','delete')) {
            $delete = Form::open(['route' => ['users.destroy', base64_encode($this->id)], 'method' => 'delete', 'class' => 'd-inline'])
                . "<button type='submit' class='btn btn-default btn-sm action-delete delete' style='border: 1px solid #ef0b0b;'
					             data-title='Delete' data-toggle='tooltip' data-placement='top'>
                                <i class='fas text-red fa-trash'></i>
                         </button>"
                . Form::close();
        }

        return [
            'id' => $this->id,
            'username' => $this->username,
            'name' => $this->name,
            'email' => $this->email,
            'role' => optional($this->role)->name,
            'status' => '<div class="badge ' . ($this->active ? 'badge-success' : 'badge-warning') . '">' . ($this->active ? 'Active' : 'Inactive') . '</div>',
            'action' => $edit . $delete
        ];
    }
}
