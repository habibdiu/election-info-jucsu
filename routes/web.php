<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberCandidateController;
use App\Http\Controllers\PositionController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');



//Member Candidate Routes
Route::match(['get', 'post'], 'member/candidate/add', [MemberCandidateController::class, 'member_candidate_add'])->name('member_candidate.add');
Route::match(['get', 'post'], 'member/candidate/edit/{id}', [MemberCandidateController::class, 'member_candidate_edit'])->name('member_candidate.edit');
Route::get('member/candidate/list',[MemberCandidateController::class,'member_candidate_list'])->name('member_candidate.list');
Route::delete('member/candidate/delete/{id}',[MemberCandidateController::class,'member_candidate_delete'])->name('member_candidate.delete');



//Member Position Routes
Route::match(['get', 'post'], 'position/add', [PositionController::class, 'position_add'])->name('position.add');
Route::match(['get', 'post'], 'position/edit/{id}', [PositionController::class, 'position_edit'])->name('position.edit');
Route::get('position/list',[PositionController::class,'position_list'])->name('position.list');
Route::delete('position/delete/{id}',[PositionController::class,'position_delete'])->name('position.delete');