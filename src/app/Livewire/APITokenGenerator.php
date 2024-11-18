<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Validate; 

class APITokenGenerator extends Component
{
    #[Validate('required')]
    public $tokenName;
    public $token;
    public $tokenOutput;
    public $isVisible = false;

    public function generateToken(){
        $this->validate();
        if($this->token == ""){
            $this->token = auth()->user()->createToken($this->tokenName)->plainTextToken;
        }
        $this->tokenOutput = str_repeat("*", strlen($this->token));
    }

    public function toggleVisibility(){
        $this->tokenOutput = $this->tokenOutput == $this->token ? str_repeat("*", strlen($this->token)) : $this->token;
        $this->isVisible = $this->tokenOutput == $this->token;
    }
    public function render()
    {
        return view('livewire.a-p-i-token-generator');
    }
}