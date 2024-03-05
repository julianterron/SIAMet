<?php

namespace Spatie\Permission\Exceptions;

use Illuminate\Contracts\Auth\Access\Authorizable;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UnauthorizedException extends HttpException
{
    private $requiredRoles = [];

    private $requiredPermissions = [];

    public static function forRoles(array $roles): self
    {
        $message = 'El usuario no tiene los roles correctos.';

        if (config('permission.display_role_in_exception')) {
            $message .= ' Los roles necesarios son '.implode(', ', $roles);
        }

        $exception = new static(403, $message, null, []);
        $exception->requiredRoles = $roles;

        return $exception;
    }

    public static function forPermissions(array $permissions): self
    {
        $message = 'El usuario no tiene los permisos correctos.';

        if (config('permission.display_permission_in_exception')) {
            $message .= ' Los permisos necesarios son '.implode(', ', $permissions);
        }

        $exception = new static(403, $message, null, []);
        $exception->requiredPermissions = $permissions;

        return $exception;
    }

    public static function forRolesOrPermissions(array $rolesOrPermissions): self
    {
        $message = 'El usuario no tiene ninguno de los derechos de acceso necesarios.';

        if (config('permission.display_permission_in_exception') && config('permission.display_role_in_exception')) {
            $message .= ' Necessary roles or permissions are '.implode(', ', $rolesOrPermissions);
        }

        $exception = new static(403, $message, null, []);
        $exception->requiredPermissions = $rolesOrPermissions;

        return $exception;
    }

    public static function missingTraitHasRoles(Authorizable $user): self
    {
        $class = get_class($user);

        return new static(403, "Authorizable class `{$class}` must use Spatie\Permission\Traits\HasRoles trait.", null, []);
    }

    public static function notLoggedIn(): self
    {
        return new static(403, 'El usuario no ha iniciado sesión.', null, []);
    }

    public function getRequiredRoles(): array
    {
        return $this->requiredRoles;
    }

    public function getRequiredPermissions(): array
    {
        return $this->requiredPermissions;
    }
}
