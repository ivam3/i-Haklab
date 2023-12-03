<?php
/**
 *
 * @author A. Grandt <php@grandt.com>
 *
 * Classes to assist in handling extra fields
 *
 */

namespace ZipMerge\Zip\Core\ExtraField;

class GenericExtraField extends AbstractExtraField {
    /**
     * @return string The version of the field for the Local Header.
     */
    public function getLocalField() {
        return parent::encodeField($this->header, $this->localData);
    }

    /**
     * @return string The version of the field for the Central Header.
     */
    public function getCentralField() {
        if ($this->centralData != null) {
            return parent::encodeField($this->header, $this->centralData);
        }
        return $this->getLocalField();        
    }
}
