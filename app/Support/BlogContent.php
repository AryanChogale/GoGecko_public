<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;

class BlogContent
{
    /**
     * Normalize legacy block JSON or arrays into HTML for editing/rendering.
     */
    public static function normalizeToHtml(mixed $content): string
    {
        if (is_array($content)) {
            return self::blocksToHtml($content);
        }

        if (!is_string($content) || trim($content) === '') {
            return '';
        }

        $decoded = json_decode($content, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return self::blocksToHtml($decoded);
        }

        return $content;
    }

    public static function blocksToHtml(array $blocks): string
    {
        $html = [];

        foreach ($blocks as $block) {
            if (!is_array($block)) {
                continue;
            }

            $header = trim((string) ($block['header'] ?? ''));
            $subheader = trim((string) ($block['subheader'] ?? ''));
            $content = trim((string) ($block['content'] ?? ''));

            if ($header !== '') {
                $html[] = '<h2>' . e($header) . '</h2>';
            }

            if ($subheader !== '') {
                $html[] = '<h3>' . e($subheader) . '</h3>';
            }

            if ($content !== '') {
                $paragraphs = preg_split("/\r\n|\n|\r/", $content) ?: [];

                foreach ($paragraphs as $paragraph) {
                    $paragraph = trim($paragraph);

                    if ($paragraph !== '') {
                        $html[] = '<p>' . e($paragraph) . '</p>';
                    }
                }
            }
        }

        return implode("\n", $html);
    }

    public static function sanitizeHtml(?string $html): string
    {
        $html = (string) $html;

        if (trim($html) === '') {
            return '';
        }

        $dom = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8" ?><body>' . $html . '</body>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $body = $dom->getElementsByTagName('body')->item(0);

        if (!$body) {
            return '';
        }

        self::sanitizeNode($body);

        $output = '';
        foreach ($body->childNodes as $child) {
            $output .= $dom->saveHTML($child);
        }

        return trim($output);
    }

    public static function plainText(mixed $content): string
    {
        $html = self::normalizeToHtml($content);

        return trim(html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    }

    public static function hasMeaningfulContent(?string $html): bool
    {
        $text = preg_replace('/\s+/u', ' ', str_replace("\xc2\xa0", ' ', self::plainText($html)));

        return trim((string) $text) !== '';
    }

    private static function sanitizeNode(DOMNode $node): void
    {
        /** @var array<string, string[]> $allowed */
        $allowed = [
            'body' => [],
            'p' => [],
            'br' => [],
            'strong' => [],
            'em' => [],
            'u' => [],
            'h2' => [],
            'h3' => [],
            'h4' => [],
            'ul' => [],
            'ol' => [],
            'li' => [],
            'blockquote' => [],
            'a' => ['href', 'target', 'rel'],
        ];

        foreach (iterator_to_array($node->childNodes) as $child) {
            if (!$child instanceof DOMElement) {
                continue;
            }

            $tag = strtolower($child->tagName);

            if (!array_key_exists($tag, $allowed)) {
                if (in_array($tag, ['script', 'style', 'iframe', 'object', 'embed'], true)) {
                    $child->parentNode?->removeChild($child);
                    continue;
                }

                while ($child->firstChild) {
                    $child->parentNode?->insertBefore($child->firstChild, $child);
                }

                $child->parentNode?->removeChild($child);
                continue;
            }

            foreach (iterator_to_array($child->attributes ?? []) as $attribute) {
                if (!in_array(strtolower($attribute->nodeName), $allowed[$tag], true)) {
                    $child->removeAttribute($attribute->nodeName);
                }
            }

            if ($tag === 'a') {
                $href = trim((string) $child->getAttribute('href'));

                if ($href === '' || !preg_match('/^(https?:|mailto:|tel:|\/|#)/i', $href)) {
                    $child->removeAttribute('href');
                } else {
                    $child->setAttribute('target', '_blank');
                    $child->setAttribute('rel', 'noopener noreferrer');
                }
            }

            self::sanitizeNode($child);
        }
    }
}
