<tr>
    <td class="px-4 py-3 filament-tables-text-column ">
        Over all Total:
    </td>
    <td class="filament-tables-cell">
        <div class="px-4 py-3 filament-tables-text-column">

            ₱ {{ number_format( (float) $this->getTableRecords()->sum('amount') , 2, '.', '') }}

        </div>
    </td>

</tr>

