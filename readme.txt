/**
*
*	Avatar Generator
*
**/
PURPOSE:
Layers images to produce a single output in the UX setting of an avatar system.
An avatar is a fictional character representing the user, although it would be
easy to reformat this to have other purposes for layering images together and producing
a single image with the PHP GD library.

/*
*	Authors - Chronologically
*/
Chad Cashman II - 2015
	chadc.me

/*
*	Directory Structure
*/
root
	library
	template

/*
*	Installation
*/
// Folder Creation
Please make sure that an images/ directory is created in the root with an avatar/ and
users/ subdirectory.

// File Updates

// Image Layering
The `avatar_item_groups` table will hold the labels for your item groups to be
associated with the images/avatar/ directory. Upload the images in their corresponding
folders (images/avatar/[group]/image.gif), and add an entry to the `avatar_images` table:
	`filename` references the files name (.gif only, do not add extension)
	`layer` refences the order images are layered (1 is lowest)
	`startX` references the original images beginning X coordinate
	`startY` references the original images beginning Y coordinate
	`endX` references the copied images beginning X coordinate
	`endX` references the copied images beginning Y coordinate
	`opacity` references the image transparency (0 = opaque)

// Adding an Item
Add a row the `avatar_items` table:
	`group_id` references `avatar_item_groups`.`id`
	`is_removable` references the ability to remove the item from the avatar

Connect the images by using the `avatar_items_to_images` table:
	`item_id` references `avatar_items`.`id`
	`image_id` references `avatar_images`.`id`

Connect the item to a user with `avatar_items_to_users` table:
	`item_id` references `avatar_items`.`id`
	`user_id` references YOUR_USER_TABLE.YOUR_USER_ID
	`isactive` references if the item is equipped