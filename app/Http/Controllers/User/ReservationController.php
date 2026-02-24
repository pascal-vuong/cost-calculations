<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Settings;

class ReservationController extends Controller
{

private function prepareCalculation(array $slots, Settings $settings) {

    $basePrice = $settings->base_price;
    $extraFee = $settings->extra_fee;
    $member = $settings->member_discount;
    $superMember = $settings->super_member_discount;

    $total = 0;
    $result = [];

    foreach ($slots as $index => $slot) {
        $fee = $extraFee;
        $gotFullDiscount = false;

        if ($slot['playerType'] === 'child') {
            $fee = 0;
            $gotFullDiscount = true;
        }

        elseif ($slot['playerType'] === 'youth') {
            $fee *= 0.50;
        }

        $result[] = [
            'speler' => $slot['index'],
            'type'   => $slot['playerType'],
            'fee' => $fee,
            'got_full_discount' => $gotFullDiscount
        ];
    }

    usort($result, function ($a, $b) {
        return $b['fee'] <=> $a['fee'];
    });
    
    $result = collect($result)
        ->map(function ($slot, $index) {
            $slot['fee_is_applied'] = $index >= 2;

            return $slot;
        });

    $total = $result->where('fee_is_applied', true)->sum('fee')+$basePrice;
    $result = $result->map(function ($slot) use($total, $member, $superMember) {
        $totalWhenSlotIsUsed = $total;

        if ($slot['type'] === 'member') {
            $totalWhenSlotIsUsed *= (1 - $member);
        }

        if ($slot['type'] === 'superMember') {
            $totalWhenSlotIsUsed *= (1 - $superMember);
        }

        // $total = het normale totaal
        // $totalWhenSlotIsUsed = het totaal als korting van deze slot wordt gebruikt
        $slot['total_with_reservation_discount'] = $totalWhenSlotIsUsed;

        return $slot;
    });

    /* cheapest slot heeft nu de beste korting
    die korting gaan we nu toepassen bij het berekenen van de prijzen van alle slots
    */
    $cheapestSlot = $result->sortBy('total_with_reservation_discount')->first();

    if ($cheapestSlot['type'] === 'member') {
        $basePrice *= (1 - $member);
    }

    if ($cheapestSlot['type'] === 'superMember') {
        $basePrice *= (1 - $superMember);
    }

    $basePricePerSlot = $basePrice / $result->where('fee_is_applied', false)->where('got_full_discount', false)->count();

    $result = $result->values()->map(function ($slot, $index) use ($basePricePerSlot, $cheapestSlot, $member, $superMember) {
        $slot['price'] = $basePricePerSlot;
        if ($index > 1) {
            $slot['price'] = $slot['fee'];
            if ($cheapestSlot['type'] === 'member') {
                $slot['price'] *= (1 - $member);
            }
            if ($cheapestSlot['type'] === 'superMember') {
                $slot['price'] *= (1 - $superMember);
            }
        }

        return $slot;
    });

    $total = $result->sum('price');
    $pricePerPlayer = $total / $index;

    return compact(
        'total',
        'result',
        'pricePerPlayer'
    );
}


    /**
     * Toon het reserveringsformulier
     */
    public function create()
    {
        $settings = Settings::first();

        if (!$settings) {
            abort(500, 'Instellingen zijn nog niet ingesteld door admin.');
        }

        $playerTypes = [
            [
                'value' => '',
                'label' => '-- Geen --',
            ], [
                'value' => 'greenfee',
                'label' => 'Greenfee',
            ], [
                'value' => 'member',
                'label' => 'Member',
            ], [
                'value' => 'superMember',
                'label' => 'Super',
            ], [
                'value' => 'youth',
                'label' => 'Jeugd'
            ], [
                'value' => 'child',
                'label' => 'Kind'
            ],
        ];

        return view('reservation.create', compact('settings', 'playerTypes'));
    }

    /**
     * Hier ga jij de berekening maken
     */
    public function calculate(StoreReservationRequest $request)
    {
        $settings = Settings::first();

        if (!$settings) {
            abort(500, 'Instellingen ontbreken.');
        }

        $membership = array_filter($request->input('membership'));
        
        $slots = [];
        foreach($membership as $index => $m) {
            $slots[] = [
                'playerType' => $m,
                'index' => $index + 1,
            ];
        }

        $calculation = $this->prepareCalculation($slots, $settings);

        return view('reservation.result', $calculation);
    }
}