<?php

namespace Drupal\buto_embed_field\Plugin\video_embed_field\Provider;

use Drupal\video_embed_field\ProviderPluginBase;

/**
 * @VideoEmbedProvider(
 *   id = "buto",
 *   title = @Translation("Buto")
 * )
 */
class Buto extends ProviderPluginBase {

    public function renderEmbedCode($width, $height, $autoplay) {
        return [
            '#type' => 'html_tag',
            '#tag' => 'iframe',
            '#attributes' => [
                'width' => $width,
                'height' => $height,
                'frameborder' => '0',
                'allowfullscreen' => 'allowfullscreen',
                'src' => sprintf('//embed.buto.tv/%s', $this->getVideoId(), $autoplay),
            ],
        ];
    }

    public function getRemoteThumbnailUrl() {
        $response = http_get(sprintf('https://api.buto.tv/v2/video/%s', $this->getVideoID()));
        return $response['uri']['thumbnail'];
    }

    public static function getIdFromInput($input) {
        preg_match("/(https?:\/\/)?(play|embed).buto.tv\/(?<id>.*)/", $input, $matches);
        return isset($matches['id']) ? $matches['id'] : FALSE;
    }

}
