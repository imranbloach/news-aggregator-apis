<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordResetRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;

class PasswordResetController extends Controller
{
    /**
     * @OA\Post(
     *     path="/forgot-password",
     *     tags={"Authentication"},
     *     summary="Request a password reset link",
     *     description="Sends a password reset link to the user's email.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", example="imran@gmail.com")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password reset link sent successfully."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to send password reset link."
     *     )
     * )
     */

    public function sendResetLinkEmail(PasswordResetRequest $request)
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Password reset link sent successfully.'], 200)
            : response()->json(['message' => 'Failed to send password reset link.'], 500);
    }


    /**
     * @OA\Post(
     *     path="/reset-password",
     *     tags={"Authentication"},
     *     summary="Reset user password",
     *     description="Resets the user's password using the provided token.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string"),
     *             @OA\Property(property="email", type="string", example="user@example.com"),
     *             @OA\Property(property="password", type="string", example="newpassword123"),
     *             @OA\Property(property="password_confirmation", type="string", example="newpassword123")
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Password reset successfully."
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Password reset failed."
     *     )
     * )
     */

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => bcrypt($request->password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => 'Password reset successfully.'], 200)
            : response()->json(['message' => 'Password reset failed.'], 500);
    }
}
