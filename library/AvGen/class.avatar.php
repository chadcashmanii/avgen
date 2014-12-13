<?php
/**
 * Class Avatar
 */
class Avatar extends AvatarClass {
    // Image Variables
    public $height      = 780;
    public $width       = 400;
    private $location   = "images/avatar/";

    // Avatar Image Settings
    public $defaultStartX;
    public $defaultStartY;
    public $defaultEndX;
    public $defaultEndY;
    public $defaultOpacity  = 100;

    /**
     * @param int $height
     * @param int $width
     */
    public function __construct($height = 780, $width = 400) {
        // Initialize Image Size
        $this->height = $height;
        $this->width = $width;
    }

    /**
     * Outputs Avatar Images
     * @param int $userId
     */
    public function avatar($userId = 1) {
        if(is_numeric($userId) && $userId > 0) {
            self::_generateAvatar($userId);
        }
    }

    /**
     * Refreshes Avatar by User Id
     * @param int $userId
     * @return bool
     */
    public function refreshAvatar($userId = 1) {
        $return = false;
        if(is_numeric($userId) && $userId > 0) {
            self::_generateAvatar($userId, false);
            $return = true;
        }
        return $return;
    }

    /**
     * Generates Avatar PNG Image
     */
    private function _generateAvatar($userId, $display = true) {
        // Create White Background
        $background = imagecreatetruecolor($this->width, $this->height);
        $color = imagecolorallocate($background, 255, 255, 255);
        imagefilledrectangle($background, 0, 0, $this->width, $this->height, $color);

        // Get Images Ordered by Layer
        $imageSQL = "
            SELECT images.*, groups.`title` as `group`
            FROM `avatar_images` images
            RIGHT JOIN `avatar_items_to_images` ii
              ON ii.`image_id` = images.`id`
            RIGHT JOIN `avatar_items` items
              ON ii.`item_id` = items.`id`
            RIGHT JOIN `avatar_items_to_users` iu
              ON iu.`item_id` = items.`id`
            RIGHT JOIN `avatar_users` users
              ON users.`id` = iu.`user_id`
            RIGHT JOIN `avatar_item_groups` groups
              ON groups.`id` = items.`group_id`
            WHERE users.`id` = $userId
            AND iu.`isactive` = TRUE
            ORDER BY `layer` ASC
        ";
        $images = $this->dbo->run($imageSQL);

        // Loop through Images and Merge
        foreach($images as $image) {
            $imageLocation = $this->location
             . $image["group"]
             . "/" . $image["filename"] . ".gif";
            $imageResource = imagecreatefromgif($imageLocation);
            imagecopymerge(
                $background,
                $imageResource,
                $image['startX'],
                $image['startY'],
                $image['endX'],
                $image['endY'],
                $this->width,
                $this->height,
                $image['opacity']
            );
        }

        // Output Image
        if($display) {
            header('Content-type: image/png');
            imagepng($background);
        }

        // Cache Image
        imagepng($background, "images/users/user_" . $userId . '.png');
    }
}