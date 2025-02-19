<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(ContactRequest $request): JsonResponse
    {
        try {
            $contact = Contact::create($request->validated());

            return response()->json([
                'message' => 'Message envoyé avec succès',
                'data' => $contact
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de l\'envoi du message',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $contacts = Contact::query()
                ->when($request->has('unread'), function ($query) {
                    return $query->unread();
                })
                ->latest()
                ->paginate(10);

            return response()->json($contacts);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la récupération des messages',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Contact $contact): JsonResponse
    {
        return response()->json($contact);
    }

    public function markAsRead(Contact $contact): JsonResponse
    {
        try {
            $contact->update(['is_read' => true]);

            return response()->json([
                'message' => 'Message marqué comme lu',
                'data' => $contact
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Contact $contact): JsonResponse
    {
        try {
            $contact->delete();

            return response()->json([
                'message' => 'Message supprimé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la suppression',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}