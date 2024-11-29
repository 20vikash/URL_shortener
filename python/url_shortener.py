from hash_table import HashTable

class URLShortener:
    def __init__(self):
        self.ht = HashTable(1000)
    
    def shorten(self, url):
        return self.ht.insert(url)
    
    def get_real_url(self, hash_):
        print("hash is {}".format(int(hash_)))
        return self.ht.search(int(hash_))
