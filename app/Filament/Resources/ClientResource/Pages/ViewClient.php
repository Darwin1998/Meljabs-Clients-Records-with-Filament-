<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\View\View;
class ViewClient extends ViewRecord
{
    protected static string $resource = ClientResource::class;


    protected function getTableContentFooter(): ?View
    {
        return view('filament.clients.footer');
    }
}
