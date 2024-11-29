class HashTableNode:
    def __init__(self, key, value):
        self.key = key
        self.value = value
        self.next = None


class HashTable:
    def __init__(self, capacity):
        self.capacity = capacity
        self.table = [None] * capacity
    
    def hash(self, data):
        hash = 0

        for i in data:
            hash += ord(i)
        
        return hash
    
    def insert(self, data):
        hashed_value = self.hash(data)
        index = hashed_value % self.capacity

        node = HashTableNode(hashed_value, data)

        if self.table[index] == None:
            self.table[index] = node
        else:
            current = self.table[index]
            while current.next != None:
                current = current.next

            current.next = node
        
        return hashed_value

    def search(self, hash_):
        index = hash_ % self.capacity

        try:
            if self.table[index].key == hash_:
                print("Perfect match")
                return self.table[index].value
            else:
                print("Not a perfect match")
                current = self.table[index]
                while current.key == hash_:
                    current = current.next
                return current.value
        except:
            pass
