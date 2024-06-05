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

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav id="sidebar" class="bg-nav">
    <div id="sidebar_content">
        <ul id="side_items">
            <li class="side_item">
                <a href="#">
                    <i class="fa-solid fa-hospital-user"></i>
                    <span class="item-description">Paciente</span>
                </a>
            </li>

            <li class="side_item active">
                <a href="#">
                    <i class="fa-solid fa-hospital-user"></i>
                    <span class="item-description">Profissional</span>
                </a>
            </li>
        </ul>

        <button id="open_btn">
            <i id="open_btn_icon" class="fa-solid fa-chevron-right"></i>
        </button>
    </div>

    <div id="logout">
        <button id="logout_btn" wire:click="logout">
            <div>
                <i class="fa-solid fa-right-from-bracket"></i>
                <span class="item-description">Logout</span>
            </div>
        </button>
    </div>
</nav>
