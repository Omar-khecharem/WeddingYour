<?php
/**
 * Image Helper
 * 
 * Image upload processing, thumbnail generation, validation,
 * optimization, and URL generation for product/category images.
 *
 * @package App\Helpers
 */

namespace App\Helpers;

class Image
{
    private static array $supportedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    /**
     * Upload an image file
     */
    public static function upload(array $file, string $directory, ?string $name = null): string|false
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = ($name ? slugify($name) : uniqid('img_')) . '.' . $ext;
        $filepath = $directory . DS . $filename;

        // Create directory if needed
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (move_uploaded_file($file['tmp_name'], $filepath)) {
            self::optimize($filepath);
            $uploadsDir = rtrim(UPLOADS_DIR, DS) . DS;
            $relative = str_starts_with($directory, $uploadsDir)
                ? substr($directory, strlen($uploadsDir)) . '/' . $filename
                : $filename;
            return str_replace('\\', '/', $relative);
        }

        return false;
    }

    /**
     * Upload and create thumbnail
     */
    public static function uploadWithThumb(array $file, string $directory, array $sizes = ['thumb' => 150, 'medium' => 400]): array|false
    {
        $result = self::upload($file, $directory);
        if (!$result) return false;

        $paths = ['original' => $result];

        foreach ($sizes as $name => $size) {
            $thumbDir = $directory . DS . $name;
            if (!is_dir($thumbDir)) {
                mkdir($thumbDir, 0755, true);
            }
            $thumbPath = $thumbDir . DS . $result;
            copy($directory . DS . $result, $thumbPath);
            self::resize($thumbPath, $size);
            $paths[$name] = $name . '/' . $result;
        }

        return $paths;
    }

    /**
     * Resize image to specified width (maintaining aspect ratio)
     */
    public static function resize(string $filepath, int $maxWidth, int $maxHeight = 0): bool
    {
        if (!file_exists($filepath)) return false;

        $info = getimagesize($filepath);
        if (!$info) return false;

        [$width, $height, $type] = $info;
        $image = self::createImage($filepath, $type);
        if (!$image) return false;

        // Calculate new dimensions
        $ratio = $width / $height;
        if ($maxHeight === 0) {
            $newWidth = $maxWidth;
            $newHeight = $newWidth / $ratio;
        } else {
            if ($width / $height > 1) {
                $newWidth = $maxWidth;
                $newHeight = $newWidth / $ratio;
            } else {
                $newHeight = $maxHeight;
                $newWidth = $newHeight * $ratio;
            }
        }

        $thumb = imagecreatetruecolor((int)$newWidth, (int)$newHeight);

        // Preserve transparency for PNG/GIF
        if ($type === IMAGETYPE_PNG || $type === IMAGETYPE_GIF) {
            imagealphablending($thumb, false);
            imagesavealpha($thumb, true);
        }

        imagecopyresampled($thumb, $image, 0, 0, 0, 0, (int)$newWidth, (int)$newHeight, $width, $height);

        self::saveImage($thumb, $filepath, $type);
        imagedestroy($image);
        imagedestroy($thumb);

        return true;
    }

    /**
     * Create square crop of image
     */
    public static function crop(string $filepath, int $size): bool
    {
        if (!file_exists($filepath)) return false;

        $info = getimagesize($filepath);
        if (!$info) return false;

        [$width, $height, $type] = $info;
        $image = self::createImage($filepath, $type);
        if (!$image) return false;

        $minSize = min($width, $height);
        $x = ($width - $minSize) / 2;
        $y = ($height - $minSize) / 2;

        $thumb = imagecreatetruecolor($size, $size);

        if ($type === IMAGETYPE_PNG || $type === IMAGETYPE_GIF) {
            imagealphablending($thumb, false);
            imagesavealpha($thumb, true);
        }

        imagecopyresampled($thumb, $image, 0, 0, (int)$x, (int)$y, $size, $size, $minSize, $minSize);

        self::saveImage($thumb, $filepath, $type);
        imagedestroy($image);
        imagedestroy($thumb);

        return true;
    }

    /**
     * Optimize image (compress)
     */
    public static function optimize(string $filepath, int $quality = null): bool
    {
        if (!file_exists($filepath)) return false;

        $quality = $quality ?? IMAGE_QUALITY;
        $info = getimagesize($filepath);
        if (!$info) return false;

        $type = $info[2];
        $image = self::createImage($filepath, $type);
        if (!$image) return false;

        // For JPEG, compress; for PNG, compress losslessly
        if ($type === IMAGETYPE_JPEG) {
            imagejpeg($image, $filepath, $quality);
        } elseif ($type === IMAGETYPE_PNG) {
            imagepng($image, $filepath, 9);
        } elseif ($type === IMAGETYPE_WEBP) {
            imagewebp($image, $filepath, $quality);
        }

        imagedestroy($image);
        return true;
    }

    /**
     * Delete an image and its thumbnails
     */
    public static function delete(string $filename, string $directory, array $subdirs = ['thumb', 'medium']): bool
    {
        $deleted = false;

        $mainPath = $directory . DS . $filename;
        if (file_exists($mainPath)) {
            unlink($mainPath);
            $deleted = true;
        }

        foreach ($subdirs as $subdir) {
            $path = $directory . DS . $subdir . DS . $filename;
            if (file_exists($path)) {
                unlink($path);
            }
        }

        return $deleted;
    }

    /**
     * Get image URL
     */
    public static function url(string $path, string $size = ''): string
    {
        if (empty($path)) {
            return asset('images/placeholder.png');
        }

        $base = UPLOADS_URL;
        if ($size) {
            $base .= '/' . $size;
        }

        return url($base . '/' . ltrim($path, '/'));
    }

    /**
     * Validate uploaded image
     */
    public static function validate(array $file): array
    {
        $errors = [];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $uploadErrors = [
                UPLOAD_ERR_INI_SIZE => 'File exceeds server upload limit.',
                UPLOAD_ERR_FORM_SIZE => 'File exceeds form upload limit.',
                UPLOAD_ERR_PARTIAL => 'File was only partially uploaded.',
                UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
                UPLOAD_ERR_NO_TMP_DIR => 'Server missing temporary directory.',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
            ];
            $errors[] = $uploadErrors[$file['error']] ?? 'Unknown upload error.';
            return $errors;
        }

        // Check file size
        if ($file['size'] > MAX_UPLOAD_SIZE) {
            $errors[] = 'File size must not exceed ' . (MAX_UPLOAD_SIZE / 1024 / 1024) . ' MB.';
        }

        // Check type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);

        if (!in_array($mime, self::$supportedTypes)) {
            $errors[] = 'File must be an image (JPEG, PNG, GIF, or WebP).';
        }

        // Check dimensions
        $info = getimagesize($file['tmp_name']);
        if ($info && ($info[0] < 50 || $info[1] < 50)) {
            $errors[] = 'Image dimensions are too small (minimum 50x50 pixels).';
        }

        return $errors;
    }

    /**
     * Create image resource from file
     */
    private static function createImage(string $filepath, int $type): \GdImage|false
    {
        return match ($type) {
            IMAGETYPE_JPEG => imagecreatefromjpeg($filepath),
            IMAGETYPE_PNG => imagecreatefrompng($filepath),
            IMAGETYPE_GIF => imagecreatefromgif($filepath),
            IMAGETYPE_WEBP => imagecreatefromwebp($filepath),
            default => false
        };
    }

    /**
     * Save image resource to file
     */
    private static function saveImage(\GdImage $image, string $filepath, int $type): void
    {
        match ($type) {
            IMAGETYPE_JPEG => imagejpeg($image, $filepath, IMAGE_QUALITY),
            IMAGETYPE_PNG => imagepng($image, $filepath, 9),
            IMAGETYPE_GIF => imagegif($image, $filepath),
            IMAGETYPE_WEBP => imagewebp($image, $filepath, IMAGE_QUALITY),
            default => null
        };
    }

    /**
     * Get image dimensions
     */
    public static function getDimensions(string $filepath): array|false
    {
        if (!file_exists($filepath)) return false;
        $info = getimagesize($filepath);
        return $info ? ['width' => $info[0], 'height' => $info[1], 'type' => $info['mime']] : false;
    }

    /**
     * Generate data URL for small images
     */
    public static function toDataUrl(string $filepath): string
    {
        if (!file_exists($filepath)) return '';
        $type = mime_content_type($filepath);
        $data = base64_encode(file_get_contents($filepath));
        return "data:{$type};base64,{$data}";
    }

    /**
     * Get placeholder image URL
     */
    public static function placeholder(int $width = 400, int $height = 400): string
    {
        return "https://placehold.co/{$width}x{$height}/f0f0f0/cccccc?text=No+Image";
    }
}
