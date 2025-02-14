$sites = @(
    "jp.mercari.com",
    "www.jp.mercari.com",
    "facebook.com",
    "www.facebook.com",
    "netflix.com",
    "www.netflix.com",
    "steampowered.com",
    "store.steampowered.com",
    "x.com",
    "www.x.com",
    "prydwen.gg",
    "www.prydwen.gg",
    "play.limitlesstcg.com",
    "instagram.com",
    "www.instagram.com",
    "kissanime.com.ru",
    "www.kissanime.com.ru",
    "shopee.com",
    "www.shopee.com",
    "lazada.com",
    "www.lazada.com"
)

foreach ($site in $sites) {
    Write-Output "Unblocking $site..."
    Remove-NetFirewallRule -DisplayName "Block $site" -ErrorAction SilentlyContinue
}

Write-Output "✅ Website unblocking rules applied successfully."
