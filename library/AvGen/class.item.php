<?php
class AvatarItem extends AvatarClass {

    public function getItemsByGroup($group, $user = false) {
        return $this->_getItemsByGroup($group, $user);
    }

    private function _getItemsByGroup($group, $user) {
        $return = false;
        if($group && is_numeric($group)) {
            // todo: change string to id
            /*if(is_string($group) && !is_numeric($group) && "" != $group) {
                $group = $this->_getGroup($group);
            }*/

            $sql = "SELECT i.*, g.`title` as `group_title`, img.`filename` as `filename`,"
                . " iu.`id` as `iuid`"
                . " FROM `avatar_items` i"
                . " RIGHT JOIN `avatar_item_groups` g"
                . " ON g.`id` = i.`group_id`"
                . " RIGHT JOIN `avatar_items_to_users` iu"
                . " ON iu.`item_id` = i.`id`"
                . " RIGHT JOIN `avatar_items_to_images` ii"
                . " ON ii.`item_id` = i.`id`"
                . " RIGHT JOIN `avatar_images` img"
                . " ON img.`id` = ii.`image_id`"
                . " WHERE i.`group_id` = $group";
            if($user && is_numeric($user)) {
                $sql .= " AND iu.`user_id` = $user";
                    //. " AND iu.`isactive` = FALSE";
            }
            $sql .= " ORDER BY i.`title`";
            $results = $this->dbo->run($sql);
            if(is_array($results)) {
                $return = $results;
            }
        }
        return $return;
    }

    public function getItemsByUser($user, $removable = false) {
        return $this->_getItemsByUser($user, $removable);
    }

    private function _getItemsByUser($user, $removable) {
        $return = false;
        if($user && is_numeric($user)) {
            // todo: change string to id
            /*if(is_string($group) && !is_numeric($group) && "" != $group) {
                $group = $this->_getGroup($group);
            }*/

            $sql = "SELECT i.*, u.`id` as `iuid` FROM `avatar_items` i RIGHT JOIN `avatar_items_to_users` u"
             . " ON u.`item_id` = i.`id` WHERE u.`user_id` = $user";
            if(!$removable) {
                $sql .= " AND i.`is_removable` = TRUE AND u.`isactive` = TRUE";
            }
            $sql .= " ORDER BY i.`title`";
            $results = $this->dbo->run($sql);
            if(is_array($results)) {
                $return = $results;
            }
        }
        return $return;
    }

    public function addItem($userId, $itemsToUsers) {
        $return = false;
        if($itemsToUsers && is_numeric($itemsToUsers)) {
            $groupId = $this->_groupIdByItem($itemsToUsers);
            if(
                ($groupId && is_numeric($groupId))
                && ($userId && is_numeric($userId))) {
                $return = $this->_addItem($userId, $itemsToUsers, $groupId);
            }
        }
        return $return;
    }

    private function _addItem($userId, $itemsToUsers, $groupId) {
        $return = false;
        $sql = "UPDATE `avatar_items_to_users`"
            . " SET `isactive` = TRUE"
            . " WHERE `id` = $itemsToUsers";
        $this->removeItemsByUserAndGroup($userId, $groupId);
        $this->dbo->run($sql, false);
        $return = true;
        return $return;
    }

    private function _groupIdByItem($itemsToUsers) {
        $return = false;
        $sql = "SELECT i.`group_id` FROM `avatar_items` i"
         . " RIGHT JOIN `avatar_items_to_users` iu"
         . " ON iu.`item_id` = i.`id`"
         . " WHERE iu.`id` = $itemsToUsers";
        $results = $this->dbo->run($sql);
        if(is_array($results) && !empty($results)) {
            $return = $results[0]['group_id'];
        }
        return $return;
    }

    public function removeItem($itemsToUsers) {
        return $this->_removeItem($itemsToUsers);
    }

    private function _removeItem($itemsToUsers) {
        $return = false;
        if($itemsToUsers && is_numeric($itemsToUsers)) {
            $sql    = "UPDATE `avatar_items_to_users` iu"
                    . " RIGHT JOIN `avatar_items` i ON i.`id` = iu.`item_id`"
                    . " SET iu.`isactive` = FALSE"
                    . " WHERE iu.`id` = $itemsToUsers AND i.`is_removable` = TRUE";
            $this->dbo->run($sql, false);
            $return = true;
        }
        return $return;
    }

    public function removeItemsByUserAndGroup($user, $group) {
        return $this->_removeItemsByUserAndGroup($user, $group);
    }

    private function _removeItemsByUserAndGroup($user, $group) {
        $return = false;
        if(($user && is_numeric($user)) && ($group && is_numeric($group))) {
            $sql = "UPDATE `avatar_items_to_users` iu"
             . " RIGHT JOIN `avatar_items` i ON i.`id` = iu.`item_id`"
             . " SET iu.`isactive` = FALSE"
             . " WHERE iu.`user_id` = $user AND i.`group_id` = $group";
            $this->dbo->run($sql, false);
            $return = true;
        }
        return $return;
    }

    public function removeItemsByUser($user) {
        return $this->_removeItemsByUser($user);
    }

    private function _removeItemsByUser($user, $removable = false) {
        $return = false;
        if($user && is_numeric($user)) {
            $sql = "UPDATE `avatar_items` i RIGHT JOIN `avatar_items_to_users` iu"
                . " ON iu.`item_id` = i.`id`"
                . " SET iu.`isactive` = FALSE"
                . " WHERE iu.`user_id` = $user";
            if(!$removable) {
                $sql .= " AND i.`is_removable` = TRUE";
            }
            $this->dbo->run($sql, false);
            $return = true;
        }
        return $return;
    }

    /**
     * @param $groupTitle
     * @return bool
     */
    private function _getGroup($groupTitle) {
        $return = false;
        if($groupTitle) {
            $sql = "SELECT `id` FROM `item_groups` WHERE `title` = ?";
            $bindString = 's';
            $response = $this->dbo->select($sql,$bindString,$groupTitle);
            echo(print_r($response));
            if(is_array($response) && !empty($response)) {
                $return = $response['id'];
            }
        }
        return $return;
    }
}