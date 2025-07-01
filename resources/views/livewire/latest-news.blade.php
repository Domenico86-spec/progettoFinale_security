<div>
    <h3>Articles suggestions for you, get inspired!</h3>
    <form wire:submit.prevent="fetchNews">
            <label for="apiSelect">Breaking news around the world</label>
            <div class="d-flex">
                <select wire:model="selectedCountry" id="apiSelect" class="form-select">
                    <option value="">Choose country</option>
                    <option value="http://internal.finance:8001/user-data.php">Italy</option>
                    <option value="gb">United Kingdom</option>
                    <option value="us">United States</option>
                </select>
                <button type="submit" class="btn btn-info">Go</button>
            </div>
        </form>
    <div>
        @if(isset($news['error']))
            <p>{{ $news['error'] }}</p>
        @elseif(isset($news['articles']))
            @forelse($news['articles'] as $article)
                <div class="news-article">
                    <h4>{{ $article['title'] }}</h4>
                    <p>{{ $article['description'] }}</p>
                    <a href="{{ $article['url'] }}" target="_blank">Read more</a>
                </div>
            @empty
            <h3>No articles around you</h3>
            @endforelse
        @endif
    </div>
</div>
