<?php
class Validator
{
    private $data;
    private $errors;
    private $error_messages;

    public function __construct()
    {
        $this->data = array();
        $this->errors = array();
        $this->error_messages = array();
    }

    function validate($data, $rules, $error_messages = array())
    {
        $this->data = $data;
        foreach ($rules as $name => $rule) {
            $this->validate_value($name, $data[$name], $rule, $data, $error_messages);
        }
        return empty($this->errors);
    }

    private function validate_value($name, $value, $rule, $data = array(), $error_messages = array())
    {
        if ($rule['require']) {
            $result = $this->validate_require($value);
            if (!$result) {
                $this->errors[$name] = 'require';
                $this->error_messages[$name] = $error_messages[$name]['require'];
                return false;
            }
        } elseif (!$rule['date']) {
            if (is_array($value)) {
                if (empty($value)) {
                    return true;
                }
            } else {
                if (strlen($value) === 0) {
                    return true;
                }
            }
        }

        foreach ($rule as $type => $option) {
            switch ($type) {
            case 'number':
                $result = $this->validate_number($value, $option);
                if (!$result) {
                    $this->errors[$name] = $type;
                    $this->error_messages[$name] = $error_messages[$name][$type];
                    return false;
                }
                break;
            case 'alphanum':
                $result = $this->validate_alphanum($value, $option);
                if (!$result) {
                    $this->errors[$name] = $type;
                    $this->error_messages[$name] = $error_messages[$name][$type];
                    return false;
                }
                break;
            case 'length':
                $result = $this->validate_length($value, $option);
                if (!$result) {
                    $this->errors[$name] = $type;
                    $this->error_messages[$name] = $error_messages[$name][$type];
                    return false;
                }
                break;
            case 'length_mb':
                $result = $this->validate_length_mb($value, $option);
                if (!$result) {
                    $this->errors[$name] = $type;
                    $this->error_messages[$name] = $error_messages[$name][$type];
                    return false;
                }
                break;
            case 'maxlength':
                $result = $this->validate_maxlength($value, $option);
                if (!$result) {
                    $this->errors[$name] = $type;
                    $this->error_messages[$name] = $error_messages[$name][$type];
                    return false;
                }
                break;
            case 'maxlength_mb':
                $result = $this->validate_maxlength_mb($value, $option);
                if (!$result) {
                    $this->errors[$name] = $type;
                    $this->error_messages[$name] = $error_messages[$name][$type];
                    return false;
                }
                break;
            case 'email':
                $result = $this->validate_email($value, $option);
                if (!$result) {
                    $this->errors[$name] = $type;
                    $this->error_messages[$name] = $error_messages[$name][$type];
                    return false;
                }
                break;
            case 'date':
                $result = $this->validate_date($data, $option);
                if (!$result) {
                    $this->errors[$name] = $type;
                    $this->error_messages[$name] = $error_messages[$name][$type];
                    return false;
                }
                break;
            case 'array':
                $result = $this->validate_array($name, $value, $option);
                if (!$result) {
                    $this->errors[$name] = $type;
                    $this->error_messages[$name] = $error_messages[$name][$type];
                    return false;
                }
                break;
            case 'equal':
                $result = $this->validate_equal($data[$name], $data[$option]);
                if (!$result) {
                    $this->errors[$name] = $type;
                    $this->error_messages[$name] = $error_messages[$name][$type];
                    return false;
                }
                break;
            case 'zenkaku':
                $result = $this->validate_zenkaku($value, $option);
                if (!$result) {
                    $this->errors[$name] = $type;
                    $this->error_messages[$name] = $error_messages[$name][$type];
                    return false;
                }
                break;
            case 'zenkaku_katakana':
                $result = $this->validate_zenkaku_katakana($value, $option);
                if (!$result) {
                    $this->errors[$name] = $type;
                    $this->error_messages[$name] = $error_messages[$name][$type];
                    return false;
                }
                break;
            case 'in_array':
                $result = $this->validate_in_array($value, $option);
                if (!$result) {
                    $this->errors[$name] = $type;
                    $this->error_messages[$name] = $error_messages[$name][$type];
                    return false;
                }
                break;
            }
        }
        return true;
    }

    private function validate_require($value, $option = true)
    {
        if (!$option) {
            return true;
        }
        if (is_array($value)) {
            return !empty($value);
        } else {
            return strlen($value) !== 0;
        }
    }

    private function validate_number($value, $option = true)
    {
        if (!$option) {
            return true;
        }
        return preg_match('{\\A\\d+\\z}', $value);
    }

    private function validate_alphanum($value, $option = true)
    {
        if (!$option) {
            return true;
        }
        return preg_match('{\\A[a-zA-Z0-9]+\\z}', $value);
    }

    private function validate_length($value, $option)
    {
        return strlen($value) === $option;
    }

    private function validate_length_mb($value, $option)
    {
        return mb_strlen($value) === $option;
    }

    private function validate_maxlength($value, $option)
    {
        return strlen($value) <= $option;
    }

    private function validate_maxlength_mb($value, $option)
    {
        return mb_strlen($value) <= $option;
    }

    private function validate_date($data, $option)
    {
        $data[$option[0]] = intval($data[$option[0]]);
        $data[$option[1]] = intval($data[$option[1]]);
        $data[$option[2]] = intval($data[$option[2]]);
        return checkdate($data[$option[1]], $data[$option[2]], $data[$option[0]]);
    }

    private function validate_email($value, $option = true)
    {
        if (!$option) {
            return true;
        }
        return preg_match('{\\A[a-zA-Z0-9_\\.\\-]+@(([a-zA-Z0-9_\\-]+\\.)+[a-zA-Z0-9]+)\\z}', $value);
    }

    private function validate_array($name, $values, $rules)
    {
        if (!is_array($values)) {
            return false;
        }
        foreach ($values as $k => $v) {
            $result = $this->validate_value($name, $v, $rules);
            if (!$result) {
                return false;
            }
        }
        return true;
    }

    private function validate_zenkaku($value, $option = true)
    {
        if (!$option) {
            return true;
        }
        return mb_convert_kana($value, 'ASK') === $value;
    }

    private function validate_zenkaku_katakana($value, $option = true)
    {
        if (!$option) {
            return true;
        }
        return preg_match ("{\\A[ァ-ンー]+\\z}u",$value);
    }

    private function validate_equal($value1, $value2)
    {
        return $value1 === $value2;
    }

    private function validate_in_array($value, $option)
    {
        return in_array($value, $option);
    }

    public function getErrors() {
        return $this->errors;
    }

    public function getErrorMessages()
    {
        return $this->error_messages;
    }
}
