<?php
/*
 * dienstplan
 *
 * Copyright (c) 2019 Christoph Fischer, https://christoph-fischer.org
 * Author: Christoph Fischer, chris@toph.de
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace App\Reports;

use App\City;
use App\Day;
use App\Liturgy;
use App\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\Shared\Converter;
use PhpOffice\PhpWord\Style\Tab;


class NewsletterReport extends AbstractWordDocumentReport
{

    public $title = 'Newsletter';
    public $group = 'Veröffentlichungen';
    public $description = 'Gottesdienstliste für den Newsletter';

    public function setup() {
        $maxDate = Day::orderBy('date', 'DESC')->limit(1)->get()->first();
        $cities = Auth::user()->cities;
        return $this->renderSetupView(['cities' => $cities]);
    }



    public function render(Request $request)
    {
        $request->validate([
            'includeCities' => 'required',
            'start' => 'required|date|date_format:d.m.Y',
            'end' => 'required|date|date_format:d.m.Y',
        ]);

        $days = Day::where('date', '>=', Carbon::createFromFormat('d.m.Y', $request->get('start')))
            ->where('date', '<=', Carbon::createFromFormat('d.m.Y', $request->get('end')))
            ->orderBy('date', 'ASC')
            ->get();

        $serviceList = [];
        foreach ($days as $day) {
            $dayTitle = $day->date->formatLocalized('%A, %d. %B %Y');
            $liturgy = Liturgy::getDayInfo($day);
            if (isset($liturgy['title'])) $dayTitle .= '&nbsp;&nbsp;&nbsp;'.$liturgy['title'];


            $serviceList[$dayTitle] = Service::with(['location', 'day'])
                ->where('day_id', $day->id)
                ->whereIn('city_id', $request->get('includeCities'))
                ->whereDoesntHave('funerals')
                ->whereDoesntHave('weddings')
                ->orderBy('time', 'ASC')
                ->get();

        }

        return view('reports.newsletter.render', compact('serviceList', 'days'));
    }



}