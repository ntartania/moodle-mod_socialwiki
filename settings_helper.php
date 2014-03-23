<?php

function socialwiki_settings_helper()
{
    $tables = array(
        SOCIALWIKI_TABLE_ALL_VERSIONS => array(
            "title" => "All Versions",
            "enable" => 0,
            "rows" => array(
                SOCIALWIKI_COLUMN_VERSION_TITLE => array(
                    "title" => "Title",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_CONTRIBUTORS => array(
                    "title" => "Contributers",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_UPDATED => array(
                    "title" => "Date Updated",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKES => array(
                    "title" => "Likes",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_FAVORITE => array(
                    "title" => "Favorite",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_MAX => array(
                    "title" => "Contributer Popularity (Max)",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_MAX => array(
                    "title" => "Contributer Like Similarity (Max)",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_MAX => array(
                    "title" => "Contributer Follow Similarity (Max)",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_MAX => array(
                    "title" => "Network Distance (Max)",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_MIN => array(
                    "title" => "Contributer Popularity (Min)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_MIN => array(
                    "title" => "Contributer Like Similarity (Min)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_MIN => array(
                    "title" => "Contributer Follow Similarity (Min)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_MIN => array(
                    "title" => "Network Distance (Min)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_AVG => array(
                    "title" => "Contributer Popularity (Avg)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_AVG => array(
                    "title" => "Contributer Like Similarity (Avg)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_AVG => array(
                    "title" => "Contributer Follow Similarity (Avg)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_AVG => array(
                    "title" => "Network Distance (Avg)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_SUM => array(
                    "title" => "Contributer Popularity (Sum)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_SUM => array(
                    "title" => "Contributer Like Similarity (Sum)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_SUM => array(
                    "title" => "Contributer Follow Similarity (Sum)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_SUM => array(
                    "title" => "Network Distance (Sum)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_VIEWS => array(
                    "title" => "Title",
                    "enable" => 1,
                ),
            ),
        ),
        SOCIALWIKI_TABLE_LIKED_VERSIONS => array(
            "title" => "Liked Versions",
            "enable" => 0,
            "rows" => array(
                SOCIALWIKI_COLUMN_VERSION_TITLE => array(
                    "title" => "Title",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_CONTRIBUTORS => array(
                    "title" => "Contributers",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_UPDATED => array(
                    "title" => "Date Updated",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKES => array(
                    "title" => "Likes",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_FAVORITE => array(
                    "title" => "Favorite",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_MAX => array(
                    "title" => "Contributer Popularity (Max)",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_MAX => array(
                    "title" => "Contributer Like Similarity (Max)",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_MAX => array(
                    "title" => "Contributer Follow Similarity (Max)",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_MAX => array(
                    "title" => "Network Distance (Max)",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_MIN => array(
                    "title" => "Contributer Popularity (Min)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_MIN => array(
                    "title" => "Contributer Like Similarity (Min)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_MIN => array(
                    "title" => "Contributer Follow Similarity (Min)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_MIN => array(
                    "title" => "Network Distance (Min)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_AVG => array(
                    "title" => "Contributer Popularity (Avg)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_AVG => array(
                    "title" => "Contributer Like Similarity (Avg)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_AVG => array(
                    "title" => "Contributer Follow Similarity (Avg)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_AVG => array(
                    "title" => "Network Distance (Avg)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_SUM => array(
                    "title" => "Contributer Popularity (Sum)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_SUM => array(
                    "title" => "Contributer Like Similarity (Sum)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_SUM => array(
                    "title" => "Contributer Follow Similarity (Sum)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_SUM => array(
                    "title" => "Network Distance (Sum)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_VIEWS => array(
                    "title" => "Title",
                    "enable" => 1,
                ),
            ),
        ),
        SOCIALWIKI_TABLE_FAVORITE_VERSIONS => array(
            "title" => "Favorite Versions",
            "enable" => 0,
            "rows" => array(
                SOCIALWIKI_COLUMN_VERSION_TITLE => array(
                    "title" => "Title",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_CONTRIBUTORS => array(
                    "title" => "Contributers",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_UPDATED => array(
                    "title" => "Date Updated",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKES => array(
                    "title" => "Likes",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_FAVORITE => array(
                    "title" => "Favorite",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_MAX => array(
                    "title" => "Contributer Popularity (Max)",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_MAX => array(
                    "title" => "Contributer Like Similarity (Max)",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_MAX => array(
                    "title" => "Contributer Follow Similarity (Max)",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_MAX => array(
                    "title" => "Network Distance (Max)",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_MIN => array(
                    "title" => "Contributer Popularity (Min)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_MIN => array(
                    "title" => "Contributer Like Similarity (Min)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_MIN => array(
                    "title" => "Contributer Follow Similarity (Min)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_MIN => array(
                    "title" => "Network Distance (Min)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_AVG => array(
                    "title" => "Contributer Popularity (Avg)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_AVG => array(
                    "title" => "Contributer Like Similarity (Avg)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_AVG => array(
                    "title" => "Contributer Follow Similarity (Avg)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_AVG => array(
                    "title" => "Network Distance (Avg)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_SUM => array(
                    "title" => "Contributer Popularity (Sum)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_SUM => array(
                    "title" => "Contributer Like Similarity (Sum)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_SUM => array(
                    "title" => "Contributer Follow Similarity (Sum)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_SUM => array(
                    "title" => "Network Distance (Sum)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_VIEWS => array(
                    "title" => "Title",
                    "enable" => 1,
                ),
            ),
        ),
        SOCIALWIKI_TABLE_USER_CREATED_VERSIONS => array(
            "title" => "User Created Versions",
            "enable" => 0,
            "rows" => array(
                SOCIALWIKI_COLUMN_VERSION_TITLE => array(
                    "title" => "Title",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_CONTRIBUTORS => array(
                    "title" => "Contributers",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_UPDATED => array(
                    "title" => "Date Updated",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKES => array(
                    "title" => "Likes",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_FAVORITE => array(
                    "title" => "Favorite",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_MAX => array(
                    "title" => "Contributer Popularity (Max)",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_MAX => array(
                    "title" => "Contributer Like Similarity (Max)",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_MAX => array(
                    "title" => "Contributer Follow Similarity (Max)",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_MAX => array(
                    "title" => "Network Distance (Max)",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_MIN => array(
                    "title" => "Contributer Popularity (Min)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_MIN => array(
                    "title" => "Contributer Like Similarity (Min)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_MIN => array(
                    "title" => "Contributer Follow Similarity (Min)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_MIN => array(
                    "title" => "Network Distance (Min)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_AVG => array(
                    "title" => "Contributer Popularity (Avg)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_AVG => array(
                    "title" => "Contributer Like Similarity (Avg)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_AVG => array(
                    "title" => "Contributer Follow Similarity (Avg)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_AVG => array(
                    "title" => "Network Distance (Avg)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_SUM => array(
                    "title" => "Contributer Popularity (Sum)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_SUM => array(
                    "title" => "Contributer Like Similarity (Sum)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_SUM => array(
                    "title" => "Contributer Follow Similarity (Sum)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_SUM => array(
                    "title" => "Network Distance (Sum)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_VIEWS => array(
                    "title" => "Title",
                    "enable" => 1,
                ),
            ),
        ),
        SOCIALWIKI_TABLE_NEW_VERSIONS => array(
            "title" => "New Versions",
            "enable" => 0,
            "rows" => array(
                SOCIALWIKI_COLUMN_VERSION_TITLE => array(
                    "title" => "Title",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_CONTRIBUTORS => array(
                    "title" => "Contributers",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_UPDATED => array(
                    "title" => "Date Updated",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKES => array(
                    "title" => "Likes",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_FAVORITE => array(
                    "title" => "Favorite",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_MAX => array(
                    "title" => "Contributer Popularity (Max)",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_MAX => array(
                    "title" => "Contributer Like Similarity (Max)",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_MAX => array(
                    "title" => "Contributer Follow Similarity (Max)",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_MAX => array(
                    "title" => "Network Distance (Max)",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_MIN => array(
                    "title" => "Contributer Popularity (Min)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_MIN => array(
                    "title" => "Contributer Like Similarity (Min)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_MIN => array(
                    "title" => "Contributer Follow Similarity (Min)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_MIN => array(
                    "title" => "Network Distance (Min)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_AVG => array(
                    "title" => "Contributer Popularity (Avg)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_AVG => array(
                    "title" => "Contributer Like Similarity (Avg)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_AVG => array(
                    "title" => "Contributer Follow Similarity (Avg)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_AVG => array(
                    "title" => "Network Distance (Avg)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_SUM => array(
                    "title" => "Contributer Popularity (Sum)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_SUM => array(
                    "title" => "Contributer Like Similarity (Sum)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_SUM => array(
                    "title" => "Contributer Follow Similarity (Sum)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_SUM => array(
                    "title" => "Network Distance (Sum)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_VIEWS => array(
                    "title" => "Title",
                    "enable" => 1,
                ),
            ),
        ),
        SOCIALWIKI_TABLE_RECOMENDED_VERSIONS => array(
            "title" => "Recomended Versions",
            "enable" => 0,
            "rows" => array(
                SOCIALWIKI_COLUMN_VERSION_TITLE => array(
                    "title" => "Title",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_CONTRIBUTORS => array(
                    "title" => "Contributers",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_UPDATED => array(
                    "title" => "Date Updated",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKES => array(
                    "title" => "Likes",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_FAVORITE => array(
                    "title" => "Favorite",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_MAX => array(
                    "title" => "Contributer Popularity (Max)",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_MAX => array(
                    "title" => "Contributer Like Similarity (Max)",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_MAX => array(
                    "title" => "Contributer Follow Similarity (Max)",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_MAX => array(
                    "title" => "Network Distance (Max)",
                    "enable" => 1,
                ),
                SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_MIN => array(
                    "title" => "Contributer Popularity (Min)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_MIN => array(
                    "title" => "Contributer Like Similarity (Min)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_MIN => array(
                    "title" => "Contributer Follow Similarity (Min)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_MIN => array(
                    "title" => "Network Distance (Min)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_AVG => array(
                    "title" => "Contributer Popularity (Avg)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_AVG => array(
                    "title" => "Contributer Like Similarity (Avg)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_AVG => array(
                    "title" => "Contributer Follow Similarity (Avg)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_AVG => array(
                    "title" => "Network Distance (Avg)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_AUTHOR_POP_SUM => array(
                    "title" => "Contributer Popularity (Sum)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_LIKE_SIM_SUM => array(
                    "title" => "Contributer Like Similarity (Sum)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_FOLLOW_SIM_SUM => array(
                    "title" => "Contributer Follow Similarity (Sum)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_NETWORK_DISTANCE_SUM => array(
                    "title" => "Network Distance (Sum)",
                    "enable" => 0,
                ),
                SOCIALWIKI_COLUMN_VERSION_VIEWS => array(
                    "title" => "Title",
                    "enable" => 1,
                ),
            ),
        ),
    );
    return $tables;
}