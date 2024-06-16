<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/');
    }
}; ?>

<nav id="sidebar" class="bg-nav">
    <div id="sidebar_content">
        <ul id="side_items">
            <li class="side_item @if (request()->routeIs('dashboard.patient')) active @endif">
                <a href="{{ route('dashboard.patient') }}"
                    data-bs-toggle="tooltip"
                    data-bs-title="{{ __('Paciente') }}"
                    data-bs-custom-class="custom-tooltip">
                    <i class="fa-solid fa-hospital-user"></i>
                    <span class="item-description">Paciente</span>
                </a>
            </li>

            <li class="side_item @if (request()->routeIs('dashboard.specialty')) active @endif">
                <a href="{{ route('dashboard.specialty') }}"
                    data-bs-toggle="tooltip"
                    data-bs-title="{{ __('Especialidade') }}"
                    data-bs-custom-class="custom-tooltip">
                    <i class="fas fa-users"></i>
                    <span class="item-description">Especialidade</span>
                </a>
            </li>

            <li class="side_item @if (request()->routeIs('dashboard.professional')) active @endif">
                <a href="{{ route('dashboard.professional') }}"
                    data-bs-toggle="tooltip"
                    data-bs-title="{{ __('Profissional') }}"
                    data-bs-custom-class="custom-tooltip">
                    <i class="fas fa-user-md"></i>
                    <span class="item-description">Profissional</span>
                </a>
            </li>

            <li class="side_item @if (request()->routeIs('dashboard.unit')) active @endif">
                <a href="{{ route('dashboard.unit') }}"
                    data-bs-toggle="tooltip"
                    data-bs-title="{{ __('Unidade') }}"
                    data-bs-custom-class="custom-tooltip">
                    <i class="fas fa-clinic-medical"></i>
                    <span class="item-description">Unidade</span>
                </a>
            </li>

            <li class="side_item @if (request()->routeIs('dashboard.address')) active @endif">
                <a href="{{ route('dashboard.address') }}"
                    data-bs-toggle="tooltip"
                    data-bs-title="{{ __('Endereço') }}"
                    data-bs-custom-class="custom-tooltip">
                    <i class="fas fa-map-marked-alt"></i>
                    <span class="item-description">Endereço</span>
                </a>
            </li>
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
