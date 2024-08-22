<?php
function getPaginationControls($currentPage, $totalPages)
{
    $html = '<div class="flex justify-center mt-4">';
    $html .= '<nav>';
    $html .= '<ul class="flex">';

    // Previous page button
    if ($currentPage > 1) {
        $html .= '<li><a href="?page=' . ($currentPage - 1) . '" class="px-4 py-2 mx-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Prev</a></li>';
    }

    // Page number buttons
    for ($i = 1; $i <= $totalPages; $i++) {
        $active = ($i == $currentPage) ? 'bg-blue-500 text-white' : 'bg-gray-200';
        $html .= '<li><a href="?page=' . $i . '" class="px-4 py-2 mx-1 rounded-lg ' . $active . '">' . $i . '</a></li>';
    }

    // Next page button
    if ($currentPage < $totalPages) {
        $html .= '<li><a href="?page=' . ($currentPage + 1) . '" class="px-4 py-2 mx-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Next</a></li>';
    }

    $html .= '</ul>';
    $html .= '</nav>';
    $html .= '</div>';

    return $html;
}
