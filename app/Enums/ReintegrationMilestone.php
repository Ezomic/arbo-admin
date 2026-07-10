<?php

declare(strict_types=1);

namespace App\Enums;

enum ReintegrationMilestone: string
{
    case ProbleemAnalyse = 'probleem_analyse';
    case PlanVanAanpak = 'plan_van_aanpak';
    case UwvMelding = 'uwv_melding';
    case EersteJaarsEvaluatie = 'eerstejaarsevaluatie';
    case WiaVoorbereiding = 'wia_voorbereiding';
    case WiaAanvraag = 'wia_aanvraag';

    public function label(): string
    {
        return match ($this) {
            self::ProbleemAnalyse => 'Probleemanalyse',
            self::PlanVanAanpak => 'Plan van aanpak',
            self::UwvMelding => 'UWV-melding',
            self::EersteJaarsEvaluatie => 'Eerstejaarsevaluatie',
            self::WiaVoorbereiding => 'WIA-voorbereiding',
            self::WiaAanvraag => 'WIA-aanvraag',
        };
    }
}
