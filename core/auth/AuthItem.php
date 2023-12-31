<?php

namespace tframe\core\auth;

use tframe\core\Application;
use tframe\core\database\MagicRecord;

/**
 * @property int $id
 * @property string $item
 * @property string $description
 * @property string $created_at
 * @property string $completed_at
 */
class AuthItem extends MagicRecord {

    public static function tableName(): string { return 'auth_items'; }

    public static function primaryKey(): string|array { return 'id'; }

    public function attributes(): array {
        return ['item', 'description'];
    }

    public function labels(): array {
        return [
            'item' => Application::t('attributes', 'Route (URL)'),
            'description' => Application::t('attributes', 'Description'),
        ];
    }

    public function rules(): array {
        return [
            'item' => [self::RULE_REQUIRED, [self::RULE_UNIQUE, 'class' => self::class], 'attribute'],
        ];
    }

    public function validateAliases(): bool {
        if (!str_contains($this->item, '@admin') and !str_contains($this->item, '@public') and !str_contains($this->item, '@api')) {
            $this->addError('item', Application::t('auth', 'Route must contains the aliases of the sites. Please see below!'));
            return false;
        } else {
            return true;
        }
    }
}