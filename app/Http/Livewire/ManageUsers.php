<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;

class ManageUsers extends Component
{
    public $users;
    public $currentUser = null;
    public $isViewModalOpen = false;
    public $isEditModalOpen = false;
    public $isDeleteModalOpen = false;
    
    public $editing = [
        'id' => '',
        'name' => '',
        'email' => '',
        'phone_number' => '',
        'role_id' => '',
        'status' => ''
    ];

    protected $listeners = ['refreshUsers' => '$refresh'];

    public function mount()
    {
        $this->users = User::all();
    }

    public function viewUser($id)
    {
        $this->currentUser = User::with('role')->find($id);
        $this->isViewModalOpen = true;
    }

    public function editUser($id)
    {
        $user = User::find($id);
        $this->editing = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone_number' => $user->phone_number,
            'role_id' => $user->role_id,
            'status' => $user->status
        ];
        $this->isEditModalOpen = true;
    }

    public function updateUser()
    {
        $this->validate([
            'editing.name' => 'required',
            'editing.email' => 'required|email|unique:users,email,'.$this->editing['id'],
            'editing.phone_number' => 'required',
            'editing.role_id' => 'required',
            'editing.status' => 'required'
        ]);

        User::find($this->editing['id'])->update([
            'name' => $this->editing['name'],
            'email' => $this->editing['email'],
            'phone_number' => $this->editing['phone_number'],
            'role_id' => $this->editing['role_id'],
            'status' => $this->editing['status']
        ]);
    
        $this->isEditModalOpen = false;
        $this->users = User::all();
        session()->flash('message', 'User updated successfully.');
    }

    public function deleteUser($id)
    {
        $this->currentUser = User::find($id);
        $this->isDeleteModalOpen = true;
    }

    public function confirmDelete()
    {
        $this->currentUser->delete();
        $this->isDeleteModalOpen = false;
        $this->users = User::all();
        session()->flash('message', 'User deleted successfully.');
    }

    public function closeModals()
    {
        $this->isViewModalOpen = false;
        $this->isEditModalOpen = false;
        $this->isDeleteModalOpen = false;
        $this->reset(['currentUser', 'editing']);
    }

    public function exportUsersToCSV()
    {
        // Get all users
        $users = User::all();
        
        $filename = 'users_export_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];
        
        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, ['ID', 'Name', 'Email', 'Phone Number', 'Role', 'Status', 'Created At']);
            
            // Add user data
            foreach ($users as $user) {
                $role = \App\Enums\UserRolesEnum::from($user->role_id)->name;
                $status = $user->status ? 'Active' : 'Suspended';
                $phone_number = "\t+60" . $user->phone_number;
                
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $phone_number,
                    $role,
                    $status,
                    $user->created_at->format('d-m-Y h:i:s')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        return view('livewire.manage-users', [
            'roles' => Role::all()
        ]);
    }
}