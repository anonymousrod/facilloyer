<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Affiche toutes les notifications du locataire connecté.
     */
    public function index()
    {
        $notifications = Auth::user()->notifications; // Récupère toutes les notifications
        return view('layouts.all_notification', compact('notifications'));
    }

    /**
     * Marque une notification comme lue.
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications->find($id);

        if ($notification) {
            $notification->markAsRead();
        }

        return redirect()->back();
    }

    /**
     * Marque toutes les notifications comme lues.
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }

    public function fetch(Request $request)
    {
        $filter = $request->get('filter');

        if ($filter === 'unread') {
            $notifications = Auth::user()->unreadNotifications;
        } else {
            $notifications = Auth::user()->notifications->sortByDesc(function ($notification) {
                return $notification->read_at ?? now()->addYear();
            });
        }

        return response()->json([
            'html' => view('layouts.notification_liste', compact('notifications'))->render()
        ]);
    }


    public function deleteAll()
    {
        Auth::user()->notifications->each->delete();

        return response()->json(['message' => 'Toutes les notifications ont été supprimées.']);
    }

    public function deleteNotification($id)
    {
        $notification = Auth::user()->notifications->find($id);

        if ($notification) {
            $notification->delete();
            return response()->json(['success' => true, 'message' => 'Notification supprimée']);
        }

        return response()->json(['success' => false, 'message' => 'Notification introuvable'], 404);
    }
}
