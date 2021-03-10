<?php
/**
 * Pfarrplaner
 *
 * @package Pfarrplaner
 * @author Christoph Fischer <chris@toph.de>
 * @copyright (c) 2020 Christoph Fischer, https://christoph-fischer.org
 * @license https://www.gnu.org/licenses/gpl-3.0.txt GPL 3.0 or later
 * @link https://github.com/potofcoffee/pfarrplaner
 * @version git: $Id$
 *
 * Sponsored by: Evangelischer Kirchenbezirk Balingen, https://www.kirchenbezirk-balingen.de
 *
 * Pfarrplaner is based on the Laravel framework (https://laravel.com).
 * This file may contain code created by Laravel's scaffolding functions.
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

namespace App\Http\Requests;

use App\Baptism;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreBaptismRequest
 * @package App\Http\Requests
 */
class StoreBaptismRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', Baptism::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'service' => 'nullable|exists:services,id',
            'candidate_name' => 'required',
            'candidate_email' => 'nullable|email',
            'candidate_zip' => 'nullable|zip',
            'candidate_phone' => 'nullable|phone_number',
            'pronoun_set' => 'nullable|string',
            'city_id' => 'required|integer|exists:cities,id|in:' . $this->user()->writableCities->pluck('id')->implode(
                    ','
                ),
            'first_contact_on' => 'nullable|date_format:d.m.Y',
            'appointment' => 'nullable|date_format:d.m.Y H:i',
            'registered' => 'nullable|integer|between:0,1',
            'signed' => 'nullable|integer|between:0,1',
            'registration_document' => 'nullable|mimetypes:application/pdf',
        ];
    }

    public function validated()
    {
        $data = parent::validated();

        $data['candidate_address'] ??= '';
        $data['candidate_zip'] ??= '';
        $data['candidate_city'] ??= '';
        $data['candidate_phone'] ??= '';
        $data['candidate_email'] ??= '';
        $data['first_contact_with'] ??= '';
        $data['docs_where'] ??= '';
        $data['registration_document'] ??= '';
        $data['docs_ready'] ??= 0;
        $data['signed'] ??= 0;
        $data['registered'] ??= 0;

        $data['first_contact_on'] ? $data['first_contact_on'] = Carbon::createFromFormat('d.m.Y', $data['first_contact_on']) : $data['first_contact_on'] = null;
        $data['appointment'] ? $data['appointment'] = Carbon::createFromFormat('d.m.Y H:i', $data['appointment']) : $data['appointment'] = null;

        return $data;
    }
}
