<?php

use App\Helpers\Helper;
use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    public function with(): array
    {
        $permissions = [
            'patient',
            'specialty',
            'professional',
            'unit',
            'address',
            'schedule',
            'user',
        ];

        return [
            'permissions' => Helper::checkPermission($permissions, 'read'),
        ];
    }
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/');
    }
};

?>

<nav id="sidebar" class="bg-nav">
    <div id="sidebar_content">
        <ul id="side_items">
            @if($permissions['user'])
                <li class="side_item @if (request()->routeIs('dashboard.user')) active @endif">
                    <a href="{{ route('dashboard.user') }}"
                        data-bs-toggle="tooltip"
                        data-bs-title="{{ __('Usuário') }}"
                        data-bs-custom-class="custom-tooltip">
                        <i class="fas fa-user"></i>
                        <span class="item-description">Usuário</span>
                    </a>
                </li>
            @endif

            @if($permissions['patient'])
                <li class="side_item @if (request()->routeIs('dashboard.patient')) active @endif">
                    <a href="{{ route('dashboard.patient') }}"
                        data-bs-toggle="tooltip"
                        data-bs-title="{{ __('Paciente') }}"
                        data-bs-custom-class="custom-tooltip">
                        <i class="fa-solid fa-hospital-user"></i>
                        <span class="item-description">Paciente</span>
                    </a>
                </li>
            @endif

            @if($permissions['specialty'])
                <li class="side_item @if (request()->routeIs('dashboard.specialty')) active @endif">
                    <a href="{{ route('dashboard.specialty') }}"
                        data-bs-toggle="tooltip"
                        data-bs-title="{{ __('Especialidade') }}"
                        data-bs-custom-class="custom-tooltip">
                        <i class="fas fa-users"></i>
                        <span class="item-description">Especialidade</span>
                    </a>
                </li>
            @endif

            {{-- @if($permissions['professional'])
                <li class="side_item @if (request()->routeIs('dashboard.professional')) active @endif">
                    <a href="{{ route('dashboard.professional') }}"
                        data-bs-toggle="tooltip"
                        data-bs-title="{{ __('Profissional') }}"
                        data-bs-custom-class="custom-tooltip">
                        <i class="fas fa-user-md"></i>
                        <span class="item-description">Profissional</span>
                    </a>
                </li>
            @endif --}}

            @if($permissions['unit'])
                <li class="side_item @if (request()->routeIs('dashboard.unit')) active @endif">
                    <a href="{{ route('dashboard.unit') }}"
                        data-bs-toggle="tooltip"
                        data-bs-title="{{ __('Unidade') }}"
                        data-bs-custom-class="custom-tooltip">
                        <i class="fas fa-clinic-medical"></i>
                        <span class="item-description">Unidade</span>
                    </a>
                </li>
            @endif

            @if($permissions['address'])
                <li class="side_item @if (request()->routeIs('dashboard.address')) active @endif">
                    <a href="{{ route('dashboard.address') }}"
                        data-bs-toggle="tooltip"
                        data-bs-title="{{ __('Endereço') }}"
                        data-bs-custom-class="custom-tooltip">
                        <i class="fas fa-map-marked-alt"></i>
                        <span class="item-description">Endereço</span>
                    </a>
                </li>
            @endif

            @if($permissions['schedule'])
                <li class="side_item @if (request()->routeIs('dashboard.schedule')) active @endif">
                    <a href="{{ route('dashboard.schedule') }}"
                        data-bs-toggle="tooltip"
                        data-bs-title="{{ __('Agendamento') }}"
                        data-bs-custom-class="custom-tooltip">
                        <i class="fas fa-calendar-alt"></i>
                        <span class="item-description">Agendamento</span>
                    </a>
                </li>
            @endif
        </ul>

        <button id="open_btn">
            <i id="open_btn_icon" class="fa-solid fa-chevron-right"></i>
        </button>
    </div>

    <div id="logout">
        <button id="logout_btn" wire:click="logout"
            data-bs-toggle="tooltip"
            data-bs-title="{{ __('Logout') }}"
            data-bs-custom-class="custom-tooltip">
            <div>
                <i class="fa-solid fa-right-from-bracket"></i>
                <span class="item-description">Logout</span>
            </div>
        </button>
    </div>
</nav>
