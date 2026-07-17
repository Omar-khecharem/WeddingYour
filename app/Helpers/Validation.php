<?php
/**
 * Validation Helper
 * 
 * Input validation engine supporting a wide range of validation rules
 * with customizable error messages and field aliasing.
 *
 * @package App\Helpers
 */

namespace App\Helpers;

class Validation
{
    private array $errors = [];
    private array $rules = [];
    private array $data = [];
    private array $customMessages = [];

    /**
     * Custom validation rule callbacks
     */
    private static array $extensions = [];

    /**
     * Register a custom validation rule
     */
    public static function extend(string $name, callable $callback): void
    {
        self::$extensions[$name] = $callback;
    }

    /**
     * Validate data against rules
     */
    public function validate(array $data, array $rules, array $messages = []): array
    {
        $this->data = $data;
        $this->rules = $rules;
        $this->customMessages = $messages;
        $this->errors = [];

        foreach ($rules as $field => $ruleSet) {
            if (is_string($ruleSet)) {
                $ruleSet = explode('|', $ruleSet);
            }

            $value = $data[$field] ?? null;

            foreach ($ruleSet as $rule) {
                $params = [];
                if (str_contains($rule, ':')) {
                    [$rule, $paramStr] = explode(':', $rule, 2);
                    $params = explode(',', $paramStr);
                }

                $ruleMethod = 'rule' . ucfirst($rule);
                if (method_exists($this, $ruleMethod)) {
                    $this->$ruleMethod($field, $value, $params);
                } elseif (isset(self::$extensions[$rule])) {
                    $callback = self::$extensions[$rule];
                    if (!$callback($field, $value, $params, $data)) {
                        $this->addError($field, $rule, "The {$field} field is invalid.");
                    }
                }
            }
        }

        if ($this->fails()) {
            return [];
        }

        // Return only validated fields
        $validated = [];
        foreach ($this->rules as $field => $ruleSet) {
            $validated[$field] = $this->data[$field] ?? null;
        }
        return $validated;
    }

    /**
     * Check if validation failed
     */
    public function fails(): bool
    {
        return !empty($this->errors);
    }

    /**
     * Get all errors
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * Get first error for a field
     */
    public function firstError(string $field): string
    {
        return $this->errors[$field][0] ?? '';
    }

    /**
     * Add error message
     */
    private function addError(string $field, string $rule, string $message): void
    {
        $this->errors[$field][] = $this->customMessages["{$field}.{$rule}"] ?? $message;
    }

    /**
     * Get field label
     */
    private function getLabel(string $field): string
    {
        return str_replace(['_', '-'], ' ', ucfirst($field));
    }

    // ---- Validation Rules ----

    /**
     * Required field
     */
    private function ruleRequired(string $field, mixed $value, array $params): void
    {
        if ($value === null || $value === '' || (is_array($value) && empty($value))) {
            $this->addError($field, 'required', "The {$field} field is required.");
        }
    }

    /**
     * Email format
     */
    private function ruleEmail(string $field, mixed $value, array $params): void
    {
        if ($value && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->addError($field, 'email', "The {$field} must be a valid email address.");
        }
    }

    /**
     * URL format
     */
    private function ruleUrl(string $field, mixed $value, array $params): void
    {
        if ($value && !filter_var($value, FILTER_VALIDATE_URL)) {
            $this->addError($field, 'url', "The {$field} must be a valid URL.");
        }
    }

    /**
     * Minimum length
     */
    private function ruleMin(string $field, mixed $value, array $params): void
    {
        $min = (int)($params[0] ?? 0);
        if ($value !== null && $value !== '' && mb_strlen((string)$value) < $min) {
            $this->addError($field, 'min', "The {$field} must be at least {$min} characters.");
        }
    }

    /**
     * Maximum length
     */
    private function ruleMax(string $field, mixed $value, array $params): void
    {
        $max = (int)($params[0] ?? 0);
        if ($value !== null && $value !== '' && mb_strlen((string)$value) > $max) {
            $this->addError($field, 'max', "The {$field} must not exceed {$max} characters.");
        }
    }

    /**
     * Exact length
     */
    private function ruleLength(string $field, mixed $value, array $params): void
    {
        $length = (int)($params[0] ?? 0);
        if ($value !== null && $value !== '' && mb_strlen((string)$value) !== $length) {
            $this->addError($field, 'length', "The {$field} must be exactly {$length} characters.");
        }
    }

    /**
     * Numeric value
     */
    private function ruleNumeric(string $field, mixed $value, array $params): void
    {
        if ($value !== null && $value !== '' && !is_numeric($value)) {
            $this->addError($field, 'numeric', "The {$field} must be a number.");
        }
    }

    /**
     * Integer value
     */
    private function ruleInteger(string $field, mixed $value, array $params): void
    {
        if ($value !== null && $value !== '' && !filter_var($value, FILTER_VALIDATE_INT)) {
            $this->addError($field, 'integer', "The {$field} must be an integer.");
        }
    }

    /**
     * Decimal value
     */
    private function ruleDecimal(string $field, mixed $value, array $params): void
    {
        if ($value !== null && $value !== '' && !preg_match('/^\d+(\.\d{1,2})?$/', (string)$value)) {
            $this->addError($field, 'decimal', "The {$field} must be a valid decimal number.");
        }
    }

    /**
     * Minimum numeric value
     */
    private function ruleMinValue(string $field, mixed $value, array $params): void
    {
        $min = (float)($params[0] ?? 0);
        if ($value !== null && $value !== '' && (float)$value < $min) {
            $this->addError($field, 'min_value', "The {$field} must be at least {$min}.");
        }
    }

    /**
     * Maximum numeric value
     */
    private function ruleMaxValue(string $field, mixed $value, array $params): void
    {
        $max = (float)($params[0] ?? 0);
        if ($value !== null && $value !== '' && (float)$value > $max) {
            $this->addError($field, 'max_value', "The {$field} must not exceed {$max}.");
        }
    }

    /**
     * Match another field
     */
    private function ruleMatch(string $field, mixed $value, array $params): void
    {
        $otherField = $params[0] ?? '';
        $otherValue = $this->data[$otherField] ?? null;
        if ($value !== $otherValue) {
            $this->addError($field, 'match', "The {$field} must match {$otherField}.");
        }
    }

    /**
     * Unique in database table
     */
    private function ruleUnique(string $field, mixed $value, array $params): void
    {
        $table = DB_PREFIX . ($params[0] ?? '');
        $column = $params[1] ?? $field;
        $ignoreId = $params[2] ?? null;
        $ignoreColumn = $params[3] ?? 'id';

        if ($value) {
            $db = \App\Core\Database::getInstance()->getConnection();
            $sql = "SELECT COUNT(*) FROM {$table} WHERE {$column} = :value";
            $bindings = [':value' => $value];

            if ($ignoreId) {
                $sql .= " AND {$ignoreColumn} != :ignore_id";
                $bindings[':ignore_id'] = $ignoreId;
            }

            $stmt = $db->prepare($sql);
            $stmt->execute($bindings);
            $count = (int) $stmt->fetchColumn();

            if ($count > 0) {
                $this->addError($field, 'unique', "The {$field} has already been taken.");
            }
        }
    }

    /**
     * Exists in database table
     */
    private function ruleExists(string $field, mixed $value, array $params): void
    {
        $table = DB_PREFIX . ($params[0] ?? '');
        $column = $params[1] ?? $field;

        if ($value) {
            $db = \App\Core\Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT COUNT(*) FROM {$table} WHERE {$column} = :value");
            $stmt->execute([':value' => $value]);
            $count = (int) $stmt->fetchColumn();

            if ($count === 0) {
                $this->addError($field, 'exists', "The selected {$field} is invalid.");
            }
        }
    }

    /**
     * Regex pattern
     */
    private function ruleRegex(string $field, mixed $value, array $params): void
    {
        $pattern = $params[0] ?? '/.*/';
        if ($value && !preg_match($pattern, (string)$value)) {
            $this->addError($field, 'regex', "The {$field} format is invalid.");
        }
    }

    /**
     * Phone number format (Indian)
     */
    private function rulePhone(string $field, mixed $value, array $params): void
    {
        if ($value && !preg_match('/^[+]?[0-9]{10,15}$/', preg_replace('/[\s\-\(\)]/', '', (string)$value))) {
            $this->addError($field, 'phone', "The {$field} must be a valid phone number.");
        }
    }

    /**
     * Array type
     */
    private function ruleArray(string $field, mixed $value, array $params): void
    {
        if ($value !== null && !is_array($value)) {
            $this->addError($field, 'array', "The {$field} must be an array.");
        }
    }

    /**
     * Boolean type
     */
    private function ruleBoolean(string $field, mixed $value, array $params): void
    {
        if ($value !== null && !in_array($value, [true, false, 0, 1, '0', '1', 'true', 'false'], true)) {
            $this->addError($field, 'boolean', "The {$field} must be true or false.");
        }
    }

    /**
     * Allowed values
     */
    private function ruleIn(string $field, mixed $value, array $params): void
    {
        if ($value !== null && $value !== '' && !in_array((string)$value, $params, true)) {
            $this->addError($field, 'in', "The {$field} must be one of: " . implode(', ', $params) . ".");
        }
    }

    /**
     * Allowed values (not in)
     */
    private function ruleNotIn(string $field, mixed $value, array $params): void
    {
        if ($value !== null && $value !== '' && in_array((string)$value, $params, true)) {
            $this->addError($field, 'not_in', "The {$field} is not allowed.");
        }
    }

    /**
     * File upload validation
     */
    private function ruleFile(string $field, mixed $value, array $params): void
    {
        $file = $_FILES[$field] ?? null;
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            if (in_array('required', $params)) {
                $this->addError($field, 'file', "The {$field} is required.");
            }
            return;
        }
    }

    /**
     * File mime type
     */
    private function ruleMimes(string $field, mixed $value, array $params): void
    {
        $file = $_FILES[$field] ?? null;
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) return;

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $params)) {
            $this->addError($field, 'mimes', "The {$field} must be a file of type: " . implode(', ', $params) . ".");
        }
    }

    /**
     * File size max
     */
    private function ruleMaxSize(string $field, mixed $value, array $params): void
    {
        $file = $_FILES[$field] ?? null;
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) return;

        $maxSize = (int)($params[0] ?? MAX_UPLOAD_SIZE) * 1024; // KB to bytes
        if ($file['size'] > $maxSize) {
            $this->addError($field, 'max_size', "The {$field} must not exceed " . ($maxSize / 1024 / 1024) . " MB.");
        }
    }

    /**
     * Image validation
     */
    private function ruleImage(string $field, mixed $value, array $params): void
    {
        $file = $_FILES[$field] ?? null;
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) return;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime, $allowedTypes)) {
            $this->addError($field, 'image', "The {$field} must be an image (JPEG, PNG, GIF, WebP).");
        }
    }

    /**
     * Date validation
     */
    private function ruleDate(string $field, mixed $value, array $params): void
    {
        if ($value && !strtotime($value)) {
            $this->addError($field, 'date', "The {$field} must be a valid date.");
        }
    }

    /**
     * Before date
     */
    private function ruleBefore(string $field, mixed $value, array $params): void
    {
        if ($value) {
            $beforeDate = $params[0] ?? 'today';
            $maxTime = strtotime($beforeDate);
            $valueTime = strtotime($value);
            if ($value && $valueTime >= $maxTime) {
                $this->addError($field, 'before', "The {$field} must be before {$beforeDate}.");
            }
        }
    }

    /**
     * After date
     */
    private function ruleAfter(string $field, mixed $value, array $params): void
    {
        if ($value) {
            $afterDate = $params[0] ?? 'today';
            $minTime = strtotime($afterDate);
            $valueTime = strtotime($value);
            if ($value && $valueTime <= $minTime) {
                $this->addError($field, 'after', "The {$field} must be after {$afterDate}.");
            }
        }
    }
}
