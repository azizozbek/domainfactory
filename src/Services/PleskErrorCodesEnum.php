<?php

namespace App\Services;

enum PleskErrorCodesEnum: int
{
    case AuthenticationFailed       = 1001;
    case UserAccountAlreadyExists   = 1002;
    case AgentInitializationFailed  = 1003;
    case InitialSetupNotCompleted   = 1004;
    case ApiVersionNotSupported     = 1005;
    case PermissionDenied           = 1006;
    case DataAlreadyExists          = 1007;
    case MultipleAccessDenied       = 1008;
    case InvalidVirtuozzoKey        = 1009;
    case AccessToPanelDenied        = 1010;
    case AccountDisabled            = 1011;
    case LockedLogin                = 1012;
    case ObjectDoesNotExist         = 1013;
    case ParsingError               = 1014;
    case ObjectOwnerNotFound        = 1015;
    case FeatureNotSupported        = 1017;
    case IpAddressNotFound          = 1018;
    case InvalidValue               = 1019;
    case OperationFailed            = 1023;
    case LimitReached               = 1024;
    case WrongStatusValue           = 1025;
    case ComponentNotInstalled      = 1026;
    case IpOperationFailed          = 1027;
    case UnknownAuthMethod          = 1029;
    case LicenseExpired             = 1030;
    case ComponentNotConfigured     = 1031;
    case WrongNetworkInterface      = 1032;
    case ClientAccountIncomplete    = 1033;
    case WebmailNotInstalled        = 1050;
    case SecretKeyValidationFailed  = 11003;
    case WrongDatabaseServerType    = 14008;
    case DatabaseServerNotConfigured = 14009;

    public function message(): string
    {
        return match($this) {
            self::AuthenticationFailed        => 'We could not connect to the server. Please check your credentials and try again.',
            self::UserAccountAlreadyExists    => 'This account already exists. Please choose a different username.',
            self::AgentInitializationFailed   => 'The server is currently unavailable. Please try again in a few moments.',
            self::InitialSetupNotCompleted    => 'The server is not ready yet. Please contact your administrator.',
            self::ApiVersionNotSupported      => 'The server does not support this operation. Please contact your administrator.',
            self::PermissionDenied            => 'You do not have permission to perform this action. Please contact your administrator.',
            self::DataAlreadyExists           => 'This domain already exists on the server. Please choose a different domain name.',
            self::MultipleAccessDenied        => 'Too many requests. Please wait a moment and try again.',
            self::InvalidVirtuozzoKey         => 'The server license is invalid. Please contact your administrator.',
            self::AccessToPanelDenied         => 'Access to the server is currently restricted. Please contact your administrator.',
            self::AccountDisabled             => 'This account has been disabled. Please contact your administrator.',
            self::LockedLogin                 => 'This account is temporarily locked. Please try again later or contact your administrator.',
            self::ObjectDoesNotExist          => 'The requested resource could not be found. Please check your input and try again.',
            self::ParsingError, self::WrongStatusValue => 'Something went wrong with your request. Please try again or contact support.',
            self::ObjectOwnerNotFound         => 'The account owner could not be found. Please check the username and try again.',
            self::FeatureNotSupported         => 'This feature is not available on your server. Please contact your administrator.',
            self::IpAddressNotFound           => 'The selected IP address is not available on this server. Please contact your administrator.',
            self::InvalidValue                => 'One or more values you entered are invalid. Please check your input and try again.',
            self::OperationFailed             => 'The operation could not be completed. Please check your input and try again.',
            self::LimitReached                => 'You have reached the maximum allowed limit. Please contact your administrator to increase your quota.',
            self::ComponentNotInstalled       => 'A required component is not installed on the server. Please contact your administrator.',
            self::IpOperationFailed           => 'The IP address could not be assigned. Please contact your administrator.',
            self::UnknownAuthMethod           => 'Authentication failed. Please contact your administrator.',
            self::LicenseExpired              => 'The server license has expired. Please contact your administrator.',
            self::ComponentNotConfigured      => 'A required component is not configured on the server. Please contact your administrator.',
            self::WrongNetworkInterface       => 'A network configuration error occurred. Please contact your administrator.',
            self::ClientAccountIncomplete     => 'Your account information is incomplete. Please fill in all required fields and try again.',
            self::WebmailNotInstalled         => 'Webmail is not available on this server. Please contact your administrator.',
            self::SecretKeyValidationFailed   => 'Security validation failed. Please try again or contact support.',
            self::WrongDatabaseServerType     => 'The database server type is not supported. Please contact your administrator.',
            self::DatabaseServerNotConfigured => 'The database server is not configured. Please contact your administrator.',
        };
    }
}