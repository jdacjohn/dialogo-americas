var article = {
    "article": {
        "@attributes": {
            "type": null,
            "lang": null,
            "flow_id": null
        },
        "meta": {
            "id": [],
            "keyword": {
                "@attributes": {
                    "name": null
                }
            },
            "collection": [],
            "docid": [],
            "translation": {
                "translator": {
                    "name": null
                },
                "verifier": {
                    "name": null
                }
            },
            "pay_schedule": [],
            "keywords": {
                "keyword": []
            },
            "date": null,
            "articlesource": [],
            "badge": null
        },
        "title": [],
        "date": null,
        "teaser": [],
        "body": {
            // Simple tags
                "B": null,
                "b": null,
                "bold": [],
                "i": [],
                "italic": null,
                "title": null,
                "underline": [],
                "p": null,
                "paragraph": null,
                "ins": null,

                "link": {
                    "@attributes": {
                        "href": null
                    }
                },

                // Lists
                "ul": [{
                    "li": null
                }],
                "list": {
                    "@attributes": {
                        "list-type": null // all types are bullets, so ignoring it
                    },
                    "listitem": [{
                        "bold": null,
                        "paragraph": {
                            "bold": null
                        },
                        "italic": null
                    }]
                },
                "listitem": [],

                // Complex tags
                "img-ref": {
                    "@attributes": {
                        "src": null,
                        "thumb": null,
                        "pos": null,
                        "width": null,
                        "height": null,
                        "cover": null
                    },
                    "caption": []
                },
                "video": {
                    "@attributes": {
                        "pos": null,
                        "src": null,
                        "type": null,
                        "id": null,
                        "length": null
                    },
                    "caption": []
                },
                // Only 1 test example, not implemented
                "video-hosted": {
                    "@attributes": {
                        "src": null
                    },
                    "caption": null
                },
                // It lives as its own type. It will be imported as files
                "audio": {
                    "@attributes": {
                        "src": null
                    }
                },
                // Only 1 test example, not implemented
                "callout": null,

                // Done
                "sidebar": {
                    "@attributes": {
                        "pos": null,
                        "id": null
                    },
                    "paragraph": [{
                        "bold": null
                    }]
                },

                // Only 1 test example, not implemented
                "callout-ref": {
                    "@attributes": {
                        "pos": null,
                        "ref": null
                    }
                },

                // Only found on photo-essay pages
                "slideshow": {
                    "img-ref": null, // same as img-ref
                    "images": {
                        "img-ref": null // same as img-ref
                    }
                },

                // Only found a few examples on a "special section" check again later on
                "banner": {
                    "@attributes": {
                        "src": null
                    }
                },

                // Not found on articles
                "comment": [],

                // Only found a few examples on a "special section" check again later on
                "articles": []
        },

        "source": [],
        "entryid": null,
        "volume": [],
        "soutce": null
    }
}
